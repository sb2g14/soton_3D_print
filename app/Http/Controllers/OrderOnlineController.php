<?php

namespace App\Http\Controllers;

use Alert;
use Auth;
use App\cost_code;
use App\Jobs;
use App\printers;
use App\Prints;
use App\staff;
use App\StatisticsHelper;
use App\User;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\Traits\PriceTrait; //Load Price calculation functions
use App\Http\Controllers\Traits\JobsTrait; //Loads functions used to check and modify jobs
use App\Mail\jobAccept;
use App\Mail\jobFailed;
use App\Mail\jobReject;
use App\Mail\jobSuccess;
use App\Mail\onlineRequest;
use App\Rules\CustomerNameValidation;
use App\Rules\Printer;
use App\Rules\SotonEmail;
use App\Rules\SotonID;
use App\Rules\UseCase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Support\Facades\Mail;

/** 
 * Class OrderOnlineController
 * This controller manages online jobs and prints (many to many correspondence).
 *
 * The different steps of this workflow are:
 * 1) Job is requested by customer
 * 2) requested jobs are reviewed by online manager
 *   a) print-previews are added to a job request to estimate the cost
 *   b) the requested job can be approved or rejected -> if approved, the job becomes approved
 * 3) approved jobs are reviewed by the customer
 *   a) the approved job can be accepted or rejected -> if accepted, the job becomes pending
 * 4) pending jobs are reviewed by the online manager
 *   a) prints can be created for jobs
 *   b) jobs can be marked as completed or failed -> if completed, the job becomes completed
 * 5) prints are reviewed by the online manager
 *   a) prints can be marked as successful or failed 
 * 6) completed jobs can be reviewed
 **/
class OrderOnlineController extends Controller
{
    use PriceTrait;
    use JobsTrait;
    
    //// PRIVATE (HELPER) FUNCTIONS ////
    //---------------------------------------------------------------------------------------------------------------//
    
    /** gets the counts of jobs in the different steps of the workflow**/
    private function _getCounts(){
        $counts = [];
        $count = Jobs::orderBy('created_at', 'desc')->where('status','Waiting')->where('requested_online', 1)->count();
        $counts['requests'] = ($count != 0) ? $count: null;
        $count = Jobs::orderBy('created_at', 'desc')->where('status','Approved')->where('requested_online', 1)->count();
        $counts['approved'] = ($count != 0) ? $count: null;
        $count = Jobs::orderBy('created_at', 'desc')->where('status','In Progress')->where('requested_online', 1)->count();
        $counts['pending'] = ($count != 0) ? $count: null;
        return $counts;
    }
    
    /**email the customer and notify the user**/
    private function _emailandnotify($emailaddress,$email,$notifytitle,$notifymessage){
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
    //// GENERIC PUBLIC FUNCTIONS ////
    //---------------------------------------------------------------------------------------------------------------//
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user= Auth::user();

            return $next($request);
        });
    }
    
    //// CONTROLLER BLADES ////
    //---------------------------------------------------------------------------------------------------------------//
    
    //// Workflow/ Item Collection Blades ////
    
    /**Show blade to online job manager displaying all the online job requests**/
    public function index()
    {
        $jobs = Jobs::orderBy('created_at', 'desc')->where('status','Waiting')->where('requested_online', 1)->get();
        $counts = $this->_getCounts();
        return view('OnlineJobs.index', compact('jobs','counts'));
    }

    /**Show blade to display jobs approved by online manager**/
    public function approved()
    {
        $approved_jobs = Jobs::orderBy('created_at', 'desc')->where('status','Approved')->where('requested_online', 1)->get();
        $counts = $this->_getCounts();
        return view('OnlineJobs.approved', compact('approved_jobs','counts'));
    }

    /**Show blade to display jobs approved by customer**/
    public function pending()
    {
        $pending_jobs = Jobs::orderBy('created_at', 'desc')->where('status','In Progress')->where('requested_online', 1)->get();
        $counts = $this->_getCounts();
        return view('OnlineJobs.pending', compact('pending_jobs','counts'));
    }

    /**Show blade to display and manage a list of assigned prints**/
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
       $counts = $this->_getCounts();
       return view('OnlineJobs.prints',compact('prints','jobs_in_progress','prints_of_jobs_in_progress','counts'));
    }

    /**Show blade to display and manage completed jobs**/
    public function completed()
    {
        $completed_jobs = Jobs::orderBy('created_at','desc')->where('requested_online', 1)->where('status','!=','Waiting')->where('status','!=','Approved')->where('status','!=','In Progress')->get();
        $counts = $this->_getCounts();
        return view('OnlineJobs.completed',compact('completed_jobs','counts'));
    }
    
    //// Specific Items Blade ////
    
    /**Show blade to customer to file a new online job request**/
    public function create()
    {
        $it = staff::where('role', '=', 'IT Manager')->get();
        $stats = new StatisticsHelper();
        $onlineSpeed = $stats->getOnlineSpeed(8);
        return view('OnlineJobs.create', compact('it','onlineSpeed'));
    }

    /**Show blade to online job manager displaying a specific online job request and allow to fill in all the required information.**/
    public function checkrequest($id)
    {
        $job = Jobs::findOrFail($id); // Find the job in DB by {$id}
        if($job->status !== "Waiting"){
            return redirect('OnlineJobs/requested');
        }
        return view('OnlineJobs.checkrequest', compact('job'));
    }
    
    /**Return view which displays info about approved job**/
    public function manageApproved($id)
    {
        $job = Jobs::findOrFail($id);
        if($job->status !== "Approved"){
            return redirect('OnlineJobs/requested');
        }
        return view('OnlineJobs.manageApproved', compact('job'));
    }
    
    /**Show blade to manage a specific approved jobs**/
    public function managePendingJob($id)
    {
        // Pass the job to the blade
        $job = Jobs::findOrFail($id);
        if($job->status !== "In Progress"){
            return redirect('OnlineJobs/requested');
        }
        
        // Pass all the available printers to the blade
        $available_printers = printers::all()->where('printer_status', 'Available')->where('in_use', 0)->pluck('id', 'id')->all();
        // Pass the jobs In Progress to the view
        $jobs_in_progress = Jobs::where('requested_online','=',1)->where('status','=','In Progress')
                                ->addSelect('id')->selectRaw("CONCAT(id,' ', job_title) AS id_title")
                                ->pluck('id_title','id');
        // Pass all the prints associated with the job
       $query_in_progress = $job->prints->where('status','=','In Progress')->first();
       $query_success = $job->prints->where('status','=','Success')->first();
        return view('OnlineJobs.managePendingJob', compact('job','available_printers','jobs_in_progress','query_in_progress','query_success'));
    }
    
    /**Show blade to display conversation for that job**/
    public function show($id)
    {
        // Pass the job to the blade
        $job = Jobs::findOrFail($id);
        
        // Check if user has permission to view these
        if($job->customer_name !== Auth::user()->name() && !Auth::user()->hasAnyPermission(['manage_online_jobs'])){
            return redirect('/');
        }
        
        // Assemble list of events
        // First get all the messages send regarding this job
        $messages = $job->messages()->select('updated_at    AS Date', 
                                             'staff_id      AS Name',
                                             'body          AS Message')
                                    ->get();
        $messages = $messages->map(function ($item, $key) {
            $ans = $item;
            if($item->Name != 0){ //TODO: add customer staff id
                $ans->Name = Staff::findOrFail($item->Name)->name();
            }else{
                $ans->Name = $job->customer_name;
            }
            return $ans;
        });
        $events = $messages;
        // Second get the request as an event
        $request  = collect(['Date' => $job->created_at, 
                             'Name' => $job->customer_name,
                             'Message' => "Requested Job"]);
        $events[] = $request;
        // If done, get the approval as an event
        if($job->approved_at){
            $approval = collect(['Date' => $job->approved_at, 
                                 'Name' => $job->staff_approved->name(),
                                 'Message' => "Approved Job ".$job->job_approved_comment]);
            $events[] = $approval;
        }
        // If done, get the acceptance as an event
        if($job->accepted_at){
            $accept   = collect(['Date' => $job->accepted_at, 
                                 'Name' => $job->customer_name,
                                 'Message' => "Accepted Job"]);
            $events[] = $accept;
        }
        // If done, get the finishing as an event
        if($job->finished_at){
            $finished = collect(['Date' => $job->finished_at, 
                                 'Name' => $job->staff_finished->name(),
                                 'Message' => "Completed Job"]);
            $events[] = $finished;
        }
        // Order all events by date
        $events = $events->sortBy('Date')->values();
        
        // Pass all the available printers to the blade
        $available_printers = printers::all()->where('printer_status', 'Available')->where('in_use', 0)
                                    ->pluck('id', 'id')->all();
        
        // Pass the jobs In Progress to the view
        $jobs_in_progress = Jobs::where('requested_online','=',1)->where('status','=','In Progress')
                                    ->addSelect('id')->selectRaw("CONCAT(id,' ', job_title) AS id_title")
                                    ->pluck('id_title','id');     
        
        //Find active prints that may deny job completion
        $query_in_progress = $job->prints->where('status','=','In Progress')->first();
        $query_success = $job->prints->where('status','=','Success')->first();
        
        
        return view('OnlineJobs.show', compact('job','events','available_printers','jobs_in_progress','query_in_progress','query_success'));
    }

    //// CONTROLLER ACTIONS ////
    //---------------------------------------------------------------------------------------------------------------//
    
    /**Action to store a new job:
     * The online job request is validated, stored in a DB and the online job manager notified via email
     **/
    public function store()
    {
        // Store an online request
        $online_request = request();
        
        // Define payment category
        $payment_category = $this->getPaymentCategory($online_request['customer_id']);

        // Get payment details checked
        $temp = $this->getPaymentDetails($online_request['use_case'],$online_request['budget_holder']);
        $cost_code = $temp[0];
        $online_request['use_case'] = $temp[1];
        $online_request['budget_holder'] = $temp[2];
         
        //get customer name and email
        $online_request['customer_name'] = Auth::user()->name();
        $online_request['customer_email'] = Auth::user()->email();
        
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

        // Updating database
        $job->update(array(
            'paid'=> 'No',
            'payment_category' => $payment_category,
            'use_case' => $online_request['use_case'],
            'cost_code' => $cost_code,
            'requested_online' => 1,
            'status' => 'Waiting',
            'job_title' => $online_request['job_title'],
            'budget_holder' => $online_request['budget_holder']
            )); //TODO: not all of these should be needed anymore
        
        $email = '3dprint.soton@gmail.com'; //TODO: this should come from env or config
        $this->_emailandnotify($email,
            new onlineRequest($job),
            'Your order request is now being considered!',
            'Please wait for our manager to contact you via provided email address');
        
        // Redirect to home directory
        return redirect('OnlineJobs/'.$job->id);
    }

    //// Logic for managing jobs requested by customer ////

    /**Action to initiate a new print preview
     * The print previews are being assigned to each job in order to calculate job parameters and send for a
     * confirmation by the customer
     **/
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
        $price = $this->_getPriceOfJob($assigned_print_preview["hours"],$assigned_print_preview["minutes"],$assigned_print_preview["material_amount"]);

        // Store print preview in the Database
        $print = Prints::create(array(
            'time'                  => $time,
            'price'                 => $price,
            'purpose'               => 'Use', 
            'material_amount'       => $assigned_print_preview["material_amount"],
            'status'                => 'Waiting'
        ));//TODO: purpose = "Preview"

        // Find the job in DB by {$id}
        $job = Jobs::findOrFail($id); 

        // Associate the print preview with the job
        $job->prints()->attach($print);

        // Notify that the print preview was created
        notify()->flash('The print-preview has been added to this job!', 'success', [
            'text' => 'You can either add more print-previews or accept this job and notify customer',
        ]);

        return redirect("/OnlineJobs/{$job->id}");
    }
    
    /**Action to delete a print preview
     * The print-previews can be deleted from the job request
     **/
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
        return redirect("OnlineJobs/{$job->id}");
    }

    

    /** Action to approve a requested job
     * The job is accepted and the customer is informed about the price via email.
     **/
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

        // Approve job and store the calculated total parameters in the job
        $job->approve(array(
            'total_duration' => $total_time,
            'total_material_amount' => $job->prints->sum('material_amount'),
            'total_price' => $job->prints->sum('price'),
            )
        );
        
        $this->_emailandnotify($job->customer_email,
                    new jobAccept($job),
                    'The job has been approved',
                    'An email notification has been send to the customer with the job quote');
        
        return redirect('OnlineJobs/approved');
    }

    /** Action to reject a requested job.
     * The job is rejected and customer is notified via email.**/
    public function rejectJobManager($id)
    {
        // Extract online manager comment and validate it
        $reject_message = request()->validate([
            'comment' => 'required|min:10|max:255']);
        
        // Check if user has permission to perform this action
        $job = Jobs::findOrFail($id);
        if($job->customer_name !== Auth::user()->name() && !Auth::user()->hasAnyPermission(['manage_online_jobs'])){
            return redirect('/'); //TODO: display error and somehow fail gracefully
        }        
        
        $job->deleteAll(); //Delete Job
        
        
        
        $this->_emailandnotify($job->customer_email,
                    new jobReject($job, $reject_message['comment']),
                    'The job has been rejected',
                    'An email notification has been send to the customer to explain why the job got rejected.');

        return redirect('OnlineJobs/requests');
    }


    //// Logic for managing jobs approved by a manager ////

    

    /**Action taken to accept an approved job
     * job is approved by customer
     **/
    public function customerApproved($id)
    {
        // Get job
        $job = Jobs::findOrFail($id);
    
        // Check if user has permission to perform this action
        if($job->customer_name !== Auth::user()->name() && !Auth::user()->hasAnyPermission(['manage_online_jobs'])){
            return redirect('/');
        }
        
        // Accept job
        $job->accept();

        // Locate associated print previews
        $prints = $job->prints;
        foreach($prints as $print)
        {
            $job->prints()->detach($print->id); //Break connection with job
            $print->delete(); // Delete print previews
        }

        
        if(Auth::user()->hasRole(['OnlineJobsManager'])){
            notify()->flash('The job has been accepted by the customer', 'success', [
                'text' => 'Now you can start adding prints',
            ]);
            return redirect("/OnlineJobs/".$id);
        }else{
            notify()->flash('The job has been accepted', 'success', [
                'text' => 'We will start printing your job soon.',
            ]);
            return redirect("/OnlineJobs/".$id);
        }
    }

    /**Action taken to decline an approved job
     * if job is rejected by customer
     **/
    public function customerReject($id)
    {
        $job = Jobs::findOrFail($id);
        
        // Check if user has permission to perform this action
        if($job->customer_name !== Auth::user()->name() && !Auth::user()->hasAnyPermission(['manage_online_jobs'])){
            return redirect('/');
        }
        
        $job->deleteAll(); //Delete Job

        // Notify that the job was deleted
        notify()->flash('The job request was rejected', 'success', [
            'text' => 'The job and all assigned print previews were deleted from the database',
        ]);
        if(Auth::user()->hasRole(['OnlineJobsManager'])){
            return redirect("/OnlineJobs/requests");
        }else{
            return redirect("/myprints/");
        }
    }
    

    //// Logic for managing jobs approved both by manager and by customer and related prints ////

    

    /**Action to assign prints to the currently managed job**/
    public function assignPrint(int $id)
    {
        // Validate user form entries
        $assigned_print = request()->validate([
            'printers_id' => 'required|numeric',
            'hours' => 'required|numeric',
            'minutes' => 'required|numeric',
            'material_amount' => 'required|numeric|min:0.1|max:9999',
            'multipleselect' => 'required',
            'comments' => 'max:2048',
            new Printer()
        ]);

        // Get printing time
        $time = $assigned_print["hours"].':'.sprintf('%02d', $assigned_print["minutes"]).':00'; 
        // Get cost of print
        $price = $this->_getPriceOfJob($assigned_print["hours"],$assigned_print["minutes"],$assigned_print["material_amount"]);

        // Create print in the Database
        $print = Prints::create([
            'printers_id' => $assigned_print["printers_id"],
            'time' => $time,
            'price' => $price,
            'purpose' => 'Use',
            'material_amount' => $assigned_print["material_amount"]
        ]);
        // Print gets automatically approved by online Manager
        $print->approve(['print_comment' => $assigned_print["comments"]]);
        // Print gets started immediately by online Manager
        $print->start(); // (changes status to 'In Progress')

        // Attach (multiple) jobs to the print
        foreach($assigned_print["multipleselect"] as $job_id)
        {
            // Find the job in DB by {$job_id}
            $job = Jobs::findOrFail($job_id); 

            // Associate the print with the job
            $job->prints()->attach($print);
        }

        // Notify user that the print was created
        notify()->flash('The print has been assigned to the selected jobs!', 'success', [
            'text' => 'You may proceed to print overview and actual printing',
        ]);

        return redirect("/OnlineJobs/{$id}");
    }

    /**Action to delete the print from the DB if it was created by mistake**/
    public function deletePrint(int $id)
    {
        // Get print
        $print = Prints::findOrFail($id);
        // Get jobs
        $jobs = $print->jobs;
        
        // Remove print from the database
        foreach($jobs as $job)
        {
            $job->prints()->detach($print->id); //Break connection with job
        }
        

        // Change the printer status to not in use
        printers::where('id','=', $print->printer->id)->update(array('in_use'=> 0));
        
        $print->delete();

        return redirect("OnlineJobs/prints/");
    }

    /**Action to report print as successful**/
    public function printSuccessful(int $id)
    {
        // Get print
        $print = Prints::findOrFail($id);
        // Mark print as successful
        $print->finish("Success");

        // Notify user
        notify()->flash('The print has been marked as successful!', 
                        'success', [
                        'text' => 'Please click Job Completed when all prints are finished.',
                        ]);

        return redirect("/OnlineJobs/prints");
    }

    /**Action to report print as failed**/
    public function printFailed(int $id)
    {
        // Get print
        $print = Prints::findOrFail($id);
        // Mark print as failed
        $print->finish("Failed");

        // Notify user
        notify()->flash('The print has been marked as failed', 
                        'success', [
                        'text' => 'Please restart the print and click Job Completed when all prints are finished.',
                        ]);

        return redirect("/OnlineJobs/prints");
    }
    
    /**Action to be taken when the job is successful**/
    public function jobSuccess(int $id)
    {
        // Get job
        $job = Jobs::findOrFail($id);
        // Mark job as successful
        $job->finish("Success");
        
        // Notify user and email customer
        $this->_emailandnotify($job->customer_email,
            new jobSuccess($job),
            'The job status has been completed successfully',
            'An email with the notification has been sent to the customer.'); 

        return redirect("/OnlineJobs/pending");
    }
    
    /**Actions to be taken when the job failed**/
    public function jobFailed(int $id)
    {
        // Extract job failed comment
        $failed_message = request()->validate([
            'comment' => 'required|max:255'
        ]);
        
        // Get job
        $job = Jobs::findOrFail($id);
        // Mark job as failed
        $job->finish('Failed');
        
        // Store rejection comment as message
        $mc = new MessagesController();
        $mc->_save($job->id,$failed_message['comment']);
        
        // Notify user and email customer
        $this->_emailandnotify($job->customer_email,
            new jobFailed($job, $failed_message['comment']),
            'The job status has been changed to Failed',
            'An email with the notification has been sent to the customer.');

        return redirect("/OnlineJobs/pending");
    }
}
