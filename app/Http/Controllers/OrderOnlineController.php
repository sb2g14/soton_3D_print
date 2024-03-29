<?php

namespace App\Http\Controllers;

use App\Mail\jobSuccess;
use App\Rules\SotonEmail;
use App\Rules\SotonID;
use App\Rules\UseCase;
use App\Rules\Printer;
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
use Alert;


class OrderOnlineController extends Controller
{
    /**
     * calculates the price of a job, based on print duration and material amount used
     * @param $hours int
     * @param $minutes int
     * @param $material_amount float
     * @return float
     */
    private function getPriceOfJob($hours,$minutes,$material_amount){
        // Calculation the job price £3 per h + £5 per 100g
        $prices = config('prices');
        $cost = round($prices['time'] * ($hours + $minutes / 60) + $prices['material'] * $material_amount / 100, 2);
        return $cost;
    }
    
    /** gets the counts of jobs in the different steps of the workflow**/
    private function getCounts(){
        $counts = [];
        $count = Jobs::orderBy('created_at', 'desc')->where('status','Waiting')->where('requested_online', 1)->count();
        $counts['requests'] = ($count != 0) ? $count: null;
        $count = Jobs::orderBy('created_at', 'desc')->where('status','Approved')->where('requested_online', 1)->count();
        $counts['approved'] = ($count != 0) ? $count: null;
        $count = Jobs::orderBy('created_at', 'desc')->where('status','In Progress')->where('requested_online', 1)->count();
        $counts['pending'] = ($count != 0) ? $count: null;
        return $counts;
    }
    
    //// MANAGE KEY WORKFLOW BLADES ////
    //---------------------------------------------------------------------------------------------------------------//
    // Online job manager sees all the online job requests:
    public function index()
    {
        $jobs = Jobs::orderBy('created_at', 'desc')->where('status','Waiting')->where('requested_online', 1)->get();
        $counts = $this->getCounts();
        return view('OnlineJobs.index', compact('jobs','counts'));
    }

    // Display jobs approved by Jobs Manager
    public function approved()
    {
        $approved_jobs = Jobs::orderBy('created_at', 'desc')->where('status','Approved')->where('requested_online', 1)->get();
        $counts = $this->getCounts();
        return view('OnlineJobs.approved', compact('approved_jobs','counts'));
    }

    // Display jobs approved by customer
    public function pending()
    {
        $pending_jobs = Jobs::orderBy('created_at', 'desc')->where('status','In Progress')->where('requested_online', 1)->get();
        $counts = $this->getCounts();
        return view('OnlineJobs.pending', compact('pending_jobs','counts'));
    }

    // Display and manage a list of assigned prints
    public function prints()
    {
       $prints = Prints::orderBy('created_at','desc')->where('status','In Progress')->get();

       $prints_of_jobs_in_progress = Prints::orderBy('prints.created_at','desc')
           ->crossJoin('jobs_prints', 'prints.id', '=', 'jobs_prints.prints_id')
           ->crossJoin('jobs', 'jobs_prints.jobs_id', '=', 'jobs.id')
           ->where('jobs.requested_online', 1)
           ->where('jobs.status','In Progress')
           ->distinct()
           ->select('prints.*')
           ->get();
       $counts = $this->getCounts();
       return view('OnlineJobs.prints',compact('prints','jobs_in_progress','prints_of_jobs_in_progress','counts'));
    }

    // Display and menage completed jobs
    public function completed()
    {
        $completed_jobs = Jobs::orderBy('created_at','desc')->where('requested_online', 1)->where('status','!=','Waiting')->where('status','!=','Approved')->where('status','!=','In Progress')->get();
        $counts = $this->getCounts();
        return view('OnlineJobs.completed',compact('completed_jobs','counts'));
    }

    //// WORKFLOW LOGIC GOES HERE ////
    //---------------------------------------------------------------------------------------------------------------//
    
    //email the customer and notify the user
    private function emailandnotify($emailaddress,$email,$notifytitle,$notifymessage){
        try{
            // Send an email to customer
            Mail::to($emailaddress)->queue($email);

            // Notify that the user of success
            notify()->flash($notifytitle, 'success', [
                'text' => $notifymessage,
            ]);
        }catch(\Exception $e){
            notify()->flash($notifytitle, 'warning', [
                'text' => 'There has however been an error with our email server. Please send an email to anyone who should be contacted about this.',
            ]);
        }
        
    }
    
    // Customer creates a new online job request
    public function create()
    {
        $it = staff::where('role', '=', 'IT Manager')->get(); //->orWhere('role', '=', 'IT')
        return view('OnlineJobs.create', compact('it'));
    }

    // The online job request is validated, stored in a DB and the online job manager notified via email
    public function store()
    {
        // Store an online request
        $online_request = request();

        // Overwrite the budget holder if known
        // check the module shortage exists
        $query = cost_code::all()->where('shortage','=',strtoupper($online_request['use_case']))->first();
        if ($query !== null){
            // If shortage exists, then populate budget holder with the DB data
            $online_request['budget_holder'] = $query->holder;
        }
        // check that cost code exists
        $query = cost_code::all()->where('cost_code','=',strtoupper($online_request['use_case']))->first();
        if ($query !== null){
            // If cost code exists, then populate budget holder with the DB data
            $online_request['budget_holder'] = $query->holder;
        }

        $online_request = $online_request->validate([
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
            ],
            'job_title' => [
                'required',
                'string',
                'min:8',
                'max:64'
            ],
            'budget_holder' => [
                'required',
                'string',
                'min:3',
                'max:100',
                new CustomerNameValidation
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

        // Define the use case
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
            'job_title' => $online_request['job_title'],
            'budget_holder' => $online_request['budget_holder']
            ));
        
        $email = '3dprint.soton@gmail.com';
        $this->emailandnotify($email,new onlineRequest($job),'Your order request is now being considered!','Please wait for our manager to contact you via provided email address');
        
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
        $time = $assigned_print_preview["hours"].':'.sprintf('%02d', $assigned_print_preview["minutes"]).':00'; // Created printing time
        // Create price
        $price = $this->getPriceOfJob($assigned_print_preview["hours"],$assigned_print_preview["minutes"],$assigned_print_preview["material_amount"]);

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
        $total_time = round($total_minutes/60).':'.sprintf('%02d', $total_minutes%60).':00';

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
        
        $this->emailandnotify($job->customer_email,new jobAccept($job),'The job has been approved','An email notification has been send to the customer with the job quote');
        
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

        $job->delete(); // Delete job
        
        $this->emailandnotify($job->customer_email,new jobReject($job, $reject_message['comment']),'The job has been rejected','An email notification has been send to the customer to explain why the job got rejected.');

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
        if(Auth::user()->hasRole(['OnlineJobsManager'])){
            return redirect("/OnlineJobs/pending");
        }else{
            return redirect("/myprints/");
        }
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
        if(Auth::user()->hasRole(['OnlineJobsManager'])){
            return redirect("/OnlineJobs/index");
        }else{
            return redirect("/myprints/");
        }
    }
    //// Logic for managing jobs approved both by manager and by customer ////
    //---------------------------------------------------------------------------------------------------------------//
    // Manage approved jobs
    public function managePendingJob($id)
    {
        // Pass the job to the blade
        $job = Jobs::findOrFail($id);
        // Pass all the available printers to the blade
        $available_printers = printers::all()->where('printer_status', 'Available')->where('in_use', 0)->pluck('id', 'id')->all();
        // Pass the jobs In Progress to the view
        $jobs_in_progress = Jobs::where('requested_online','=',1)->where('status','=','In Progress')->addSelect('id')->selectRaw("CONCAT(id,' ', job_title) AS id_title")->pluck('id_title','id');
//        addSelect('id')->selectRaw('job_title AS desc')->
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
            'printers_id' => 'required|numeric',
            'hours' => 'required|numeric',
            'minutes' => 'required|numeric',
            'material_amount' => 'required|numeric|min:0.1|max:9999',
            'multipleselect' => 'required',
            'comments' => 'max:2048',
            new Printer()
        ]);

        // create a print from the specified details
        $time = $assigned_print["hours"].':'.sprintf('%02d', $assigned_print["minutes"]).':00'; // Created printing time
        // Create price
        $price = $this->getPriceOfJob($assigned_print["hours"],$assigned_print["minutes"],$assigned_print["material_amount"]);

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
        $assigned_print = request()->validate([
        ]);

        $print = Prints::findOrFail($id);
        $jobs = $print->jobs;
        // Remove print from the database
        foreach($jobs as $job)
        {
            $job->prints()->detach($print->id); //Break connection with job
        }
        $print->delete();

        // Change the printer status to not in use
        printers::where('id','=', $print->printer->id)->update(array('in_use'=> 0));

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

        // Change the job flag to 'Failed'
        $job->update(array(
            'status' => 'Failed',
            'job_finished_by' => Auth::user()->staff->id
        ));
        
        $this->emailandnotify($job->customer_email,new jobFailed($job, $failed_message['comment']),'The job status has been changed to Failed','An email with the notification has been sent to the customer.');

        return redirect("/OnlineJobs/pending");
    }

    // Action to be taken when the job is successful
    public function jobSuccess($id)
    {
        $job = Jobs::findOrFail($id);

        // Change the job flag to 'Success'
        $job->update(array(
            'status' => 'Success',
            'job_finished_by' => Auth::user()->staff->id
        ));
        
        $this->emailandnotify($job->customer_email,new jobSuccess($job),'The job status has been completed successfully','An email with the notification has been sent to the customer.'); 

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

        // Change the printer status to not in use
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

        // Change the printer status to not in use
        printers::where('id','=', $print->printer->id)->update(array('in_use'=> 0));

        // Notify that the print preview was created
        notify()->flash('The print has been marked as failed', 'success', [
            'text' => 'Please restart the print and click Job Completed when all prints are finished.',
        ]);

        return redirect("/OnlineJobs/prints");
    }
}
