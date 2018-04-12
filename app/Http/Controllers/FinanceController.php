<?php

namespace App\Http\Controllers;

use App\JobsPrints;
use App\printers;
use Illuminate\Http\Request;
use App\Jobs;
use App\Prints;
use App\cost_code;
use App\StatisticsHelper;
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
        $t1 = new Carbon();
        $t1 = $t1->day(1)->hour(0)->minute(0)->second(0);
        return redirect('finance/jobs/'.$t1);
    }

    /**
     * 
     * @blade_address /finance/prints/<id>
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function jobs($month)
    {
        // Define start and end of month
        $t1 = new Carbon($month);
        $t1 = $t1->day(1)->hour(0)->minute(0)->second(0);
        $t2 = $t1->copy()->addMonth();
        // Get all the completed jobs from the specified month
        $jobs = Jobs::where('created_at', '>=', $t1)->where('created_at', '<=', $t2)->orderBy('created_at', 'desc')->where('status', 'Success')->get();
        
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
        // Define start and end of month
        $t1 = new Carbon($month);
        $t1 = $t1->day(1)->hour(0)->minute(0)->second(0);
        $t2 = $t1->copy()->addMonth();
        // Get all the completed jobs from the specified month
        $jobs = Jobs::where('created_at', '>=', $t1)->where('created_at', '<=', $t2)->orderBy('created_at', 'desc')->where('status', 'Success')->get();
        
        // get last months
        $stats = new StatisticsHelper();
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
