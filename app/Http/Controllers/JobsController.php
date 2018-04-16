<?php

namespace App\Http\Controllers;

use App\JobsPrints;
use Illuminate\Http\Request;
use App\Jobs;
use App\Prints;
use Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules\In;
use Carbon\Carbon;

/**
 * This controller manages workshop prints and jobs
 * in this scenario 1 job = 1 print
 */

class JobsController extends Controller
{

    /**
     * Function to find and redirect to the blade with the print/job details
     * @blade_address to be found
     * @param $id int, print id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        
        $job = Jobs::findOrFail($id);

        if($job->requested_online){
            // This is an online print
            return redirect('/OnlineJobs/prints');
        }  
        // This is a workshop print  
        if($job->status === "Waiting"){
            // Print is waiting for approval
            return redirect('/printingData/show/'.$job->id);
        }
        if($job->status === "Approved"){
            // Print is currently printing
            return redirect('/printingData/approved');
        }    
        // This is a workshop print
        return redirect('/printingData/edit/'.$job->id);
    }
}
