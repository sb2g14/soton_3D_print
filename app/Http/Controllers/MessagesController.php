<?php

namespace App\Http\Controllers;

use Auth;
use App\Announcement;
use App\FaultData;
use App\Jobs;
use App\Messages;
use App\printers;
use App\Prints;
use App\PublicAnnouncements;
use App\StatisticsHelper;
//use App\Http\Controllers\Traits\WorkshopTrait;
use App\Rules\Printer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;



/**
 * This controller manages messages between staff and customers for online jobs
 **/
class MessagesController extends Controller
{
    
    
    
    
    //// GENERIC PUBLIC FUNCTIONS ////
    //---------------------------------------------------------------------------------------------------------------//
    
    /** Specify pages available to an unauthenticated user **/
    public function __construct()
    {

        $this->middleware('auth');

    }
    
    public function _save($job_id,$message){
        // Collect data from a post to submit to the database:
        $msg = new Messages;
        $msg->body = $message;
        $msg->staff_id = Auth::user()->staff->id;
        $msg->job_id = $job_id;

        // Submit the data to the database
        $msg->save();
    }

    //// CONTROLLER ACTIONS ////
    //---------------------------------------------------------------------------------------------------------------//

    
    /**
     * Store a newly created message in storage.
     *
     * @param  int  $id  Job ID
     * @return \Illuminate\Http\Response
     **/
    public function store(int $id)
    {
        // Find the job in DB by {$id}
        $job = Jobs::findOrFail($id); 
        // Check if user has permission to view these
        if($job->customer_name !== Auth::user()->name() && !Auth::user()->hasAnyPermission(['manage_online_jobs'])){
            return redirect('/');
        }
        
        // Validate request from the form:
        $this -> validate(request(), [
            'body' => 'required|string|max:300|regex:/^[a-z A-Z0-9.,!?]+$/'
        ]);

        // Collect data from a post to submit to the database:
        $this->_save($id,request('body'));

        
        return redirect('/OnlineJobs/'.$id);
    }
}
