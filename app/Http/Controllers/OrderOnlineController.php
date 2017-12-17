<?php

namespace App\Http\Controllers;

use App\Mail\jobSuccess;
use App\Rules\Alphanumeric;
use App\Rules\SotonEmail;
use App\Rules\SotonID;
use App\Rules\SotonIdMinMax;
use App\Rules\UseCase;
use App\User;
use Illuminate\Http\Request;
use App\Rules\CustomerNameValidation;
use App\Jobs;
use App\Prints;
use App\cost_code;
use App\Mail\onlineRequest;
use App\Mail\jobAccept;
use App\staff;
use Carbon\Carbon;
use Auth;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Support\Facades\Mail;
use App\Mail\jobReject;
use App\Mail\jobFailed;
use App\printers;


class OrderOnlineController extends Controller
{
    //// MANAGE KEY WORKFLOW BLADES ////
    //---------------------------------------------------------------------------------------------------------------//
    // Online job manager sees all the online job requests:
    public function index()
    {
        $jobs = Jobs::orderBy('created_at', 'desc')->where('status','Waiting')->where('requested_online', 1)->get();
        return view('OnlineJobs.index', compact('jobs'));
    }

    // Display jobs approved by Jobs Manager
    public function approved()
    {
        $approved_jobs = Jobs::orderBy('created_at', 'desc')->where('status','Approved')->where('requested_online', 1)->get();

        return view('OnlineJobs.approved', compact('approved_jobs'));
    }

    // Display jobs approved by customer
    public function pending()
    {
        $pending_jobs = Jobs::orderBy('created_at', 'desc')->where('status','In Progress')->where('requested_online', 1)->get();

        return view('OnlineJobs.pending', compact('pending_jobs'));
    }

    // Display and manage a list of assigned prints
    public function prints()
    {
       $prints= Prints::orderBy('created_at','desc')->where('status','In Progress')->get();
       $jobs_in_progress = Jobs::orderBy('created_at','desc')->where('status','In Progress')->where('requested_online', 1)->get();

       return view('OnlineJobs.prints',compact('prints','jobs_in_progress'));
    }

    // Display and menage completed jobs
    public function completed()
    {
        $completed_jobs = Jobs::orderBy('created_at','desc')->where('requested_online', 1)->where('status','!=','Waiting')->where('status','!=','Approved')->where('status','!=','In Progress')->get();

        return view('OnlineJobs.completed',compact('completed_jobs'));
    }

    //// WORKFLOW LOGIC GOES HERE ////
    //---------------------------------------------------------------------------------------------------------------//
    // Customer creates a new online job request
    public function create()
    {
        $it = staff::where('role', '=', 'IT')->orWhere('role', '=', 'IT Manager')->get();
        return view('OnlineJobs.create', compact('it'));
    }

    // The online job request is validated, stored in a DB and the online job manager notified via email
    public function store()
    {
        // Validate the online request
        $online_request = request()->validate([
            'customer_name' => [
                'required',
                'string',
                'min:3',
                'max:100',
                new CustomerNameValidation
            ],
            'customer_email' => [
                "required",
                "min:14",
                "max:100",
                "email",
                new SotonEmail
            ],
            'customer_id' => [
                'required',
                'digits_between:8,9',
                new SotonID,
            ],
            'use_case' => [
                'required',
                'min:3',
                'max:30',
                'alpha_dash',
                new UseCase
            ],
            'claim_id' => [
                'required',
                'alpha_num',
                'size:16'
            ],
            'claim_passcode' => [
                'required',
                'alpha_num',
                'size:16'
            ]
        ]);

        // Store the online request in the database
        $job = Jobs::create($online_request);

        // Define payment category
        $customer_id = $online_request['customer_id'];

        if (substr($customer_id, 0, 1) == '1') {
            $payment_category = 'staff';
        } elseif (substr($customer_id, 0, 1) == '2') {
            $payment_category = 'postgraduate';
        } elseif (substr($customer_id, 0, 1) == '3') {
            $payment_category = 'masters';
        } else {
            $payment_category = 'undergraduate';
        }

        // Define a cost code
        // check the module shortage exists
        $query = cost_code::all()->where('shortage','=',strtoupper($online_request['use_case']))->first();
        if ($query !== null){
            // If shortage exists, then populate cost code and shortage with the DB data
            $cost_code = $query->value('cost_code');
            $use_case = strtoupper($online_request['use_case']);
        } else { // If shortage is not found in the DB, check whether the cost code can be found in the DB
            $query = cost_code::all()->where('cost_code','=',$online_request['use_case'])->first();
            $cost_code = $online_request['use_case'];
            if ($query !== null){ // The cost code was found. Set a corresponding flag
                $use_case = 'Cost Code - approved';
            } else { // The cost code was not found. Set a corresponding flag
                $use_case = 'Cost Code - unknown';
            }
        }

        // Updating database
        $job -> update(array(
            'paid'=> 'No',
            'payment_category' => $payment_category,
            'use_case' => $use_case,
            'cost_code' => $cost_code,
            'requested_online' => 1,
            'status' => 'Waiting',
            ));

        // Send an email to the 3d print account
        $email = '3dprint.soton@gmail.com';
//        $user = User::find(2);
        \Mail::to($email)->queue(new onlineRequest($job));

        // Notification of request acceptance
        notify()->flash('Your order request has been accepted!', 'success', [
            'text' => 'Please wait for our manager to contact you via provided email address',
        ]);
        // Redirect to home directory
        return redirect()->home();
    }

    // Online job manager reviews each online job request and fills in all the required information.
    public function checkrequest($id)
    {
        $job = Jobs::findOrFail($id); // Find the job in DB by {$id}
        return view('OnlineJobs.checkrequest', compact('job'));
    }

    // The print previews are being assigned to each job in order to calculate job parameters and send for a
    // confirmation by the customer
    //---------------------------------------------------------------------------------------------------------------//
    public function assignPrintPreview($id)
    {
        // Validate and store the printing time and material amount specified to each print preview of a current job
        $assigned_print_preview = request()->validate([
            'hours' => 'required',
            'minutes' => 'required',
            'material_amount' => 'required|numeric|min:0.1|max:9999',
            ]);

        // create a print from the specified details
        $time = $assigned_print_preview["hours"].':'.sprintf('%02d', $assigned_print_preview["minutes"]); // Created printing time
        // Create price
        $price = round(3 * ($assigned_print_preview["hours"] + $assigned_print_preview["minutes"] / 60) +
            5 * $assigned_print_preview["material_amount"] / 100, 2);

        // Store print preview in the Database
        $print = new Prints;
        $print -> time = $time;
        $print -> price = $price;
        $print -> save();

        // Update a print preview with the details entered by a customer
        $print -> update(array(
            'purpose' => 'Use',
            'material_amount' => $assigned_print_preview["material_amount"],
            'status' => 'waiting'
        ));

        $job = Jobs::findOrFail($id); // Find the job in DB by {$id}

        // Associate the print preview with the job
        $job->prints()->attach($print);

        // Notify that the print preview was created
        notify()->flash('The print-preview has been added to this job!', 'success', [
            'text' => 'You can either add more print-previews or accept this job and notify customer',
        ]);

        return redirect("/OnlineJobs/checkrequest/{$job->id}");
    }
    // The print-previews can be deleted from the job request
    public function deletePrintPreview($id)
    {
        $print = Prints::findOrFail($id);
        $job = $print->jobs->first();
        // Remove print preview from the database
        $job->prints()->detach($print->id); //Break connection with job
        $print->delete(); // Delete print preview

        // Notify the manager about deleted print-preview
        notify()->flash('The print-preview has been deleted', 'success', [
            'text' => 'You can create new print-previews',
        ]);
        return redirect("OnlineJobs/checkrequest/{$job->id}");
    }

    // Defining the logic for job management
    //---------------------------------------------------------------------------------------------------------------//
    // The job is accepted and the customer is informed about the price via email.
    public function approveRequest($id)
    {
        // Find a job by id
        $job = Jobs::findOrFail($id);

        // Calculation of the total time of the job by summing up all print previews
        $total_minutes = 0; // We transform hours to minutes and sum them up for each print preview
        foreach ($job->prints as $print){
            list($h, $i, $s) = explode(':', $print->time);
            $minutes = $h*60 + $i;
            $total_minutes = $total_minutes + $minutes;
        }
        // Coming back to hours and minutes
        $total_time = round($total_minutes/60).':'.sprintf('%02d', $total_minutes%60);

        // Remove print previews from the database
        $prints = $job->prints;
        foreach($prints as $print) {
            $job->prints()->detach($print->id); //Break connection with job
            $print->delete(); // Delete print previews
        }

        // Store the calculated total parameters in the job
        $job->update(array(
            'status' => 'Approved',
            'approved_at' => Carbon::now('Europe/London'),
            'job_approved_by' => Auth::user()->staff->id,
            'total_duration' => $total_time,
            'total_material_amount' => $job->prints->sum('material_amount'),
            'total_price' => $job->prints->sum('price'),
            )
        );

        // Send an email to customer
        Mail::to($job->customer_email)->queue(new jobAccept($job));

        // Notify the manager about successfully accepted job
        notify()->flash('The job has been approved', 'success', [
            'text' => 'Please send an email notification to the customer with the job quote',
        ]);
        return redirect('OnlineJobs/approved');
    }

    // The job is rejected and customer is notified via email.
    public function rejectJobManager($id)
    {
        // Extract online manager comment and validate it
        $reject_message = request()->validate([
            'comment' => 'required|min:10|max:255']);

        // Find a job by id
        $job = Jobs::findOrFail($id);
        // Locate associated print previews
        $prints = $job->prints;
        foreach($prints as $print) {
            $job->prints()->detach($print->id); //Break connection with job
            $print->delete(); // Delete print previews
        }

        // Send an email to customer
        Mail::to($job->customer_email)->queue(new jobReject($job, $reject_message['comment']));

        $job->delete(); // Delete job

        // Notify that the job was rejected
        notify()->flash('The job has been rejected', 'success', [
            'text' => 'Please explain why the job has been rejected via email',
        ]);

        return redirect('OnlineJobs/index');
    }

    //// Logic for managing jobs approved by manager ////
    //---------------------------------------------------------------------------------------------------------------//

    // Return view which displays info about approved job
    public function manageApproved($id)
    {
        $job = Jobs::findOrFail($id);
        return view('OnlineJobs.manageApproved', compact('job'));
    }

    // Job is approved by customer
    public function customerApproved($id)
    {
        $job = Jobs::findOrFail($id);

        $job->update(array(
            'status' => 'In Progress'
            ));

        // Locate associated print previews
        $prints = $job->prints;
        foreach($prints as $print)
        {
            $job->prints()->detach($print->id); //Break connection with job
            $print->delete(); // Delete print previews
        }

        // Notify that the job was rejected
        notify()->flash('The job has been approved by customer', 'success', [
            'text' => 'Now you can start adding prints',
        ]);
        return redirect('OnlineJobs/pending');
    }
    // Job is rejected by customer
    public function customerReject($id)
    {
        $job = Jobs::findOrFail($id);
        // Locate associated print previews
        $prints = $job->prints;
        foreach($prints as $print)
        {
            $job->prints()->detach($print->id); //Break connection with job
            $print->delete(); // Delete print previews
        }
        $job->delete(); // Delete job

        // Notify that the job was deleted
        notify()->flash('The job request was rejected', 'success', [
            'text' => 'The job and all assigned print previews were deleted from the database',
        ]);

        return redirect("/OnlineJobs/index");
    }
    //// Logic for managing jobs approved both by manager and by customer ////
    //---------------------------------------------------------------------------------------------------------------//
    // Manage approved jobs
    public function managePendingJob($id)
    {
        // Pass the job to the blade
        $job = Jobs::findOrFail($id);
        // Pass all the available printers to the blade
        $available_printers = printers::all()->where('printer_status', '!=', 'Missing')->where('printer_status', '!=', 'On Loan')->where('printer_status', '!=', 'Signed out')->where('in_use', 0)->pluck('id', 'id')->all();
        // Pass the jobs In Progress to the view
        $jobs_in_progress = Jobs::where('requested_online','=',1)->where('status','=','In Progress')->pluck('id','id');
        // Pass all the prints associated with the job
       $query_in_progress = $job->prints->where('status','=','In Progress')->first();
       $query_success = $job->prints->where('status','=','Success')->first();
        return view('OnlineJobs.managePendingJob', compact('job','available_printers','jobs_in_progress','query_in_progress','query_success'));
    }
    // Assign prints to the currently managed job
    public function assignPrint($id)
    {
        // Extract assigned print
        $assigned_print = request()->validate([
            'printers_id' => 'required',
            'hours' => 'required',
            'minutes' => 'required',
            'material_amount' => 'required|numeric|min:0.1|max:9999',
            'multipleselect' => 'required',
            'comments' => 'max:255'
        ]);

        // create a print from the specified details
        $time = $assigned_print["hours"].':'.sprintf('%02d', $assigned_print["minutes"]); // Created printing time
        // Create price
        $price = round(3 * ($assigned_print["hours"] + $assigned_print["minutes"] / 60) +
            5 * $assigned_print["material_amount"] / 100, 2);

        // Create print in the Database
        $print = Prints::create([
            'printers_id' => $assigned_print["printers_id"],
            'time' => $time,
            'price' => $price,
            'status' => 'In Progress',
            'purpose' => 'Use',
            'material_amount' => $assigned_print["material_amount"],
            'print_comment' => $assigned_print["comments"],
            'print_started_by' => Auth::user()->staff->id
        ]);

        // Attach multiple jobs to a single print
        foreach($assigned_print["multipleselect"] as $job_id)
        {
            $job = Jobs::findOrFail($job_id); // Find the job in DB by {$job_id}

            // Associate the print with the job
            $job->prints()->attach($print);
        }

        printers::where('id','=', $print->printer->id)->update(array('in_use'=> 1));

        // Notify that the print was created
        notify()->flash('The print has been assigned to the selected jobs!', 'success', [
            'text' => 'You may proceed to print overview and actual printing',
        ]);

        return redirect("/OnlineJobs/managePendingJob/{$id}");
    }

    // Delete the print from the DB if it was created by mistake
    public function deletePrint($id)
    {
        $print = Prints::findOrFail($id);
        $jobs = $print->jobs;
        // Remove print from the database
        foreach($jobs as $job)
        {
            $job->prints()->detach($print->id); //Break connection with job
        }
        $print->delete();

        // Notify the manager about deleted print-preview
        notify()->flash('The print has been deleted', 'success', [
            'text' => 'You can create new prints',
        ]);
        return redirect("OnlineJobs/managePendingJob/{$job->id}");
    }

    // Actions to be taken when the job failed
    public function jobFailed($id)
    {
        // Extract job failed comment
        $failed_message = request()->validate([
            'comment' => 'required|max:255'
        ]);

        $job = Jobs::findOrFail($id);

        // Send an email to the customer
        Mail::to($job->customer_email)->queue(new jobFailed($job, $failed_message['comment']));

        // Change the job flag to 'Failed'
        $job->update(array(
            'status' => 'Failed'
        ));

        // Notify that the job failed flag was raised and the email sent to customer
        notify()->flash('The job status has been changed to Failed', 'success', [
            'text' => 'An email with the notification has been sent to the customer',
        ]);

        return redirect("/OnlineJobs/pending");
    }

    // Action to be taken when the job is successful
    public function jobSuccess($id)
    {
        $job = Jobs::findOrFail($id);

        // Send an email notification to the customer
        Mail::to($job->customer_email)->queue(new jobSuccess($job));

        // Change the job flag to 'Success'
        $job->update(array(
            'status' => 'Success'
        ));

        // Notify that the job success flag was raised and the email sent to customer
        notify()->flash('The job status has been changed to Success', 'success', [
            'text' => 'An email with the notification has been sent to the customer',
        ]);

        return redirect("/OnlineJobs/pending");
    }

    // Action to report print as successful

    public function printSuccessful($id)
    {
        $print = Prints::findOrFail($id);
        $print->update(array(
            'print_finished_by' => Auth::user()->staff->id,
            'status' => 'Success'
        ));

        printers::where('id','=', $print->printer->id)->update(array('in_use'=> 0));

        // Notify that the print preview was created
        notify()->flash('The print has been marked as successful!', 'success', [
            'text' => 'Please click Job Completed when all prints are finished.',
        ]);

        return redirect("/OnlineJobs/prints");
    }

    // Action to report print as successful

    public function printFailed($id)
    {
        $print = Prints::findOrFail($id);
        $print->update(array(
            'print_finished_by' => Auth::user()->staff->id,
            'status' => 'Failed'
        ));

        printers::where('id','=', $print->printer->id)->update(array('in_use'=> 0));

        // Notify that the print preview was created
        notify()->flash('The print has been marked as failed', 'success', [
            'text' => 'Please restart the print and click Job Completed when all prints are finished.',
        ]);

        return redirect("/OnlineJobs/prints");
    }
}
