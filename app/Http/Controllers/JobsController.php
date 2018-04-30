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
     * Function to show all the information about a job
     * @blade_address 
     * @param $id int, job id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        
        $job = Jobs::findOrFail($id);
        $prints = $job->prints()->get();
        
        return view('jobs.show', compact('job','prints'));

        
    }
    
    /**
     * Function to find and redirect to the blade with the print/job details
     * @blade_address to be found
     * @param $id int, job id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function find($id)
    {
        $job = Jobs::findOrFail($id);
        
        if($job->requested_online){
            if($job->status === "Waiting"){
                // Job is waiting for approval
                return redirect('/OnlineJobs/request/'.$job->id);
            }
            if($job->status === "Approved"){
                // Job is waiting for customer acceptance
                return redirect('/OnlineJobs/approved/'.$job->id);
            }
            if($job->status === "Pending"){
                // Job is currently being worked on
                return redirect('/OnlineJobs/pending/'.$job->id);
            }
            // This is a completed online job
            return redirect('/OnlineJobs/finished');
        }  
        // This is a workshop job  
        if($job->status === "Waiting"){
            // Print is waiting for approval
            return redirect('/WorkshopJobs/requested'.$job->id);
        }
        if($job->status === "Approved"){
            // Print is currently printing
            return redirect('/WorkshopJobs/approved');
        }    
        // This is a workshop print
        return redirect('/WorkshopJobs/'.$job->id.'/edit');
    }
}
