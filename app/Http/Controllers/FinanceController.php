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
    public function index()
    {
        // TODO: Think about what needs to go on index page
        
        $stats = new StatisticsHelper();
        // Current Month
        $month = new Carbon();
        $month = $month->day(1)->hour(0)->minute(0)->second(0);
        
        // Get Finance for this year
        // Get all the completed jobs for this year
        $WorkshopJobs = $stats->getIncomeWorkshop($month);
        $OnlineJobs = $stats->getIncomeOnline($month);
        // Get all the assigned sessions for this year
        $demonstrators = $stats->getDemonstratorCost($month);
        
        // Get Finance for last year
        $lastyear = $month->copy()->subYear();
        // Get all the completed jobs for last year
        $WorkshopJobsPrev = $stats->getIncomeWorkshop($lastyear);
        $OnlineJobsPrev = $stats->getIncomeOnline($lastyear);
        // Get all the assigned sessions for last year
        $demonstratorsPrev = $stats->getDemonstratorCost($lastyear);
        
        // Get staff without CWP
        $nocwp = $this->getNewStaff();
        $nocwp = $nocwp->map(function ($item) {
            return ['name' => $item->name()];
        });
        $nocwp = $nocwp->implode('name', ', ');
        return view('finance.index', compact('month','WorkshopJobs','OnlineJobs','demonstrators','WorkshopJobsPrev','OnlineJobsPrev','demonstratorsPrev','nocwp'));
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
