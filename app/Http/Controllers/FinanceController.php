<?php

namespace App\Http\Controllers;

use App\JobsPrints;
use App\printers;
use Illuminate\Http\Request;
use App\Jobs;
use App\Prints;
use App\StatisticsHelper;
use App\staff;
use App\cost_code;
use App\Http\Controllers\Traits\ExcelTrait;
use Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules\In;
use Carbon\Carbon;

/**
 * This controller manages finance related things
 */

class FinanceController extends Controller
{
    use ExcelTrait;
    /**
     * 
     * @blade_address /finance
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    
    private function onlineDemonstratorCost($onlinePrints,$onlineJobs){
        $hours = 0;
        $nPrints = $onlinePrints;
        $hours += $nPrints*0.75; //45min to set up a print, observe first layers and collect completed print
        $nJobs = $onlineJobs;
        $hours += $nJobs*1.5; //1:30hour to communicate with customer, test the files and fill things in online
        return $hours*15.08;
    }
    
    private function materialCost($year){
        $stats = new StatisticsHelper();
        $material = $stats->getMaterial($year->format('Y'));
        $material = $material*1.2; //assume 20% waste
        $prices = config('prices');
        return $material*$prices['material']/100;
    }
    
    public function index()
    {
        // TODO: Think about what needs to go on index page
        
        $stats = new StatisticsHelper();
        // Current Month
        $month = new Carbon();
        $month = $month->day(1)->hour(0)->minute(0)->second(0);

        // Get Online Prints this and last year:
        $onlinePrints = $stats->getArrayOnlinePrintsLastYears(2);
        // Get Online Jobs this and last year:
        $onlineJobs = $stats->getArrayOnlineJobsLastYears(2);
        
        $finance = [];
        // Get Finance for this year
        $financeY1 = [];
        // Get all the completed jobs for this year
        $financeY1['Workshop Jobs'] = $stats->getIncomeWorkshop($month);
        $financeY1['Online Jobs'] = $stats->getIncomeOnline($month);
        // Get all the assigned sessions for this year
        $financeY1['Workshop Demonstrators**'] = -1*$stats->getDemonstratorHours($month)*15.08;
        // Estimate the cost of online demonstrators
        $financeY1['Online Demonstrators***'] = -1*$this->onlineDemonstratorCost($onlinePrints[0],$onlineJobs[0]);
        //Estimate material used this year
        $financeY1['Material****'] = -1*$this->materialCost($month);
        $finance[] = $financeY1;
        
        // Get Finance for last year
        $financeY2 = [];
        $lastyear = $month->copy()->subYear();
        // Get all the completed jobs for last year
        $financeY2['Workshop Jobs'] = $stats->getIncomeWorkshop($lastyear);
        $financeY2['Online Jobs'] = $stats->getIncomeOnline($lastyear);
        // Get all the assigned sessions for last year
        $financeY2['Workshop Demonstrators**'] = -1*$stats->getDemonstratorHours($lastyear)*15.08;
        // Estimate the cost of online demonstrators
        $financeY2['Online Demonstrators***'] = -1*$this->onlineDemonstratorCost($onlinePrints[1],$onlineJobs[1]);
        //Estimate material used last year
        $financeY2['Material****'] = -1*$this->materialCost($lastyear);
        $finance[] = $financeY2;
        
        // Get staff without CWP
        $nocwp = $this->getNewStaff();
        $nocwp = $nocwp->map(function ($item) {
            return ['name' => $item->name()];
        });
        $nocwp = $nocwp->implode('name', ', ');

        
        return view('finance.index', compact('month','finance','nocwp'));
    }
    
    
    /** get staff that have not yet shown the CWP to coordinator **/
    private function getNewStaff(){
        $staff = staff::where('CWP_date', null)
            ->where('role', '!=', 'Former Member')
            ->where('role', '!=', 'Coordinator')
            ->where('role', '!=', 'Co-Coordinator')
            ->where('role', '!=', 'Technician')
            ->get();
        return $staff;
    }
    
    private function getJobs($month){
        // Define start and end of month
        $t1 = new Carbon($month);
        $t1 = $t1->day(1)->hour(0)->minute(0)->second(0);
        $t2 = $t1->copy()->addMonth();
        // Get all the completed jobs from the specified month
        $jobs = Jobs::where('created_at', '>=', $t1)->where('created_at', '<=', $t2)->orderBy('created_at', 'desc')->where('status', 'Success')->get();
        return $jobs;
    }
    
    /**
     * 
     * @blade_address /finance/jobs
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function jobsNow()
    {
        $t1 = new Carbon();
        $t1 = $t1->day(1)->hour(0)->minute(0)->second(0);
        return redirect('finance/jobs/'.$t1->toDateString());
    }

    /**
     * 
     * @blade_address /finance/jobs/<id>
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function jobs($month)
    {
        // Get start of month
        $t1 = new Carbon($month);
        $t1 = $t1->day(1)->hour(0)->minute(0)->second(0);
        
        // Get all the completed jobs from the specified month
        $jobs = $this->getJobs($month);
        
        // get last months
        $stats = new StatisticsHelper();
        $pages = $stats->getArrayLastMonths(12);
        return view('finance.jobs', compact('jobs','t1','pages'));
    }

    /**
     * 
     * @blade_address /finance/prints/<id>
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function downloadJobs($month)
    {
        // Get all the completed jobs from the specified month
        $jobs = $this->getJobs($month);
        
        $header = ["Job ID" => 'id',
                   "Date Created" => 'created_at',
                   "Customer Name"=> 'customer_name',
                   "Customer ID" => 'customer_id',
                   "Job Title" => 'job_title',
                   "Cost Code" => 'cost_code',
                   "Budget Holder" => 'budget_holder',
                   "Time" => 'total_duration',
                   "Material Amount" => 'total_material_amount',
                   "Price" => 'total_price'];
        $this->dataExport($jobs,$header);
        return redirect('finance/jobs/'.$t1);
    }

    

    
}
