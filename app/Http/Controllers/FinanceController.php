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
    

    //// PRIVATE (HELPER) FUNCTIONS ////
    //---------------------------------------------------------------------------------------------------------------//
    
    private function _onlineDemonstratorCost($onlinePrints,$onlineJobs){
        $hours = 0;
        $nPrints = $onlinePrints;
        $hours += $nPrints*0.75; //45min to set up a print, observe first layers and collect completed print
        $nJobs = $onlineJobs;
        $hours += $nJobs*1.5; //1:30hour to communicate with customer, test the files and fill things in online
        return $hours*15.08;
    }
    
    private function _materialCost($year){
        $stats = new StatisticsHelper();
        $material = $stats->getMaterial($year->format('Y'));
        $material = $material*1.2; //assume 20% waste
        $prices = config('prices');
        return $material*$prices['material']/100;
    }
    
    private function _getFinanceForYear($year){
        $stats = new StatisticsHelper();
        $financeY = [];
        // Get all the completed jobs for this year
        $financeY['Workshop Jobs'] = $stats->getIncomeWorkshop($year);
        $financeY['Online Jobs'] = $stats->getIncomeOnline($year);
        // Get all the assigned sessions for this year
        $financeY['Workshop Demonstrators**'] = -1*$stats->getDemonstratorHours($year)*15.08;
        //Estimate material used this year
        $financeY['Material****'] = -1*$this->_materialCost($year);
        return $financeY;
    }
    
    private function _getFinanceForPastYears($n){
        $stats = new StatisticsHelper();
        // Current Month
        $month = new Carbon();
        $month = $month->day(1)->hour(0)->minute(0)->second(0);

        // Get Online Prints this and last year:
        $onlinePrints = $stats->getArrayOnlinePrintsLastYears($n);
        // Get Online Jobs this and last year:
        $onlineJobs = $stats->getArrayOnlineJobsLastYears($n);
        $year = $month->copy();
        $finance = [];
        for($i = 0; $i < $n; $i++){
            // Get Finance for the year
            $financeY = $this->_getFinanceForYear($year);
            // Estimate the cost of online demonstrators
            $financeY['Online Demonstrators***'] = -1*$this->_onlineDemonstratorCost($onlinePrints[$i],$onlineJobs[$i]);
            $finance[] = $financeY;
            //get next year
            $year = $year->subYear();
        }
        return $finance;
    }
    
    /** get staff that have not yet shown the CWP to coordinator **/
    private function _getNewStaff(){
        $staff = staff::where('CWP_date', null)
            ->where('role', '!=', 'Former Member')
            ->where('role', '!=', 'Coordinator')
            ->where('role', '!=', 'Co-Coordinator')
            ->where('role', '!=', 'Technician')
            ->get();
        return $staff;
    }
    
    private function _getJobs($month){
        // Define start and end of month
        $t1 = new Carbon($month);
        $t1 = $t1->day(1)->hour(0)->minute(0)->second(0);
        $t2 = $t1->copy()->addMonth();
        // Get all the completed jobs from the specified month
        $jobs = Jobs::where('created_at', '>=', $t1)->where('created_at', '<=', $t2)
            ->orderBy('created_at', 'desc')
            ->where('status', 'Success')
            ->get();
        return $jobs;
    }
    
    //// CONTROLLER BLADES ////
    //---------------------------------------------------------------------------------------------------------------//
    
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
        
        $finance = $this->_getFinanceForPastYears(2);
        
        
        // Get staff without CWP
        $nocwp = $this->_getNewStaff();
        $nocwp = $nocwp->map(function ($item) {
            return ['name' => $item->name()];
        });
        $nocwp = $nocwp->implode('name', ', ');

        
        return view('finance.index', compact('month','finance','nocwp'));
    }
    
    
    
    
    

    /**
     * 
     * @blade_address /finance/jobs/<date>
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function jobs($month)
    {
        // Get start of month
        $t1 = new Carbon($month);
        $t1 = $t1->day(1)->hour(0)->minute(0)->second(0);
        
        // Get all the completed jobs from the specified month
        $jobs = $this->_getJobs($month);
        
        // get last months
        $stats = new StatisticsHelper();
        $pages = $stats->getArrayLastMonths(12);
        return view('finance.jobs', compact('jobs','t1','pages'));
    }

    //// CONTROLLER ACTIONS ////
    //---------------------------------------------------------------------------------------------------------------//
        
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
     * @blade_address /finance/prints/<id>
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function downloadJobs($month)
    {
        // Get all the completed jobs from the specified month
        $jobs = $this->_getJobs($month);
        
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
