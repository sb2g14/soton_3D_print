<?php

namespace App\Http\Controllers;

use Auth; //Loads the authentication methods
use Excel; //Loads export to excel functions

use App\cost_code; //Load the cost-code model
use App\Jobs; //Load the Jobs model
use App\printers; //Load printers model
use App\Prints; //Load prints model
use App\Http\Controllers\Traits\PriceTrait; //Load Price calculation functions
use App\Http\Controllers\Traits\JobsTrait; //Loads functions used to check and modify jobs
// Load custom validation rules
use App\Rules\Alphanumeric;
use App\Rules\CustomerNameValidation;
use App\Rules\SotonEmail;
use App\Rules\SotonID;
use App\Rules\SotonIdMinMax;
use App\Rules\UseCase;

use Carbon\Carbon; //Loads Carbon for time
use Illuminate\Support\Facades\Input; //Loads the input from drop-down


/**
 * Class WorkshopJobsController
 * This controller manages workshop prints and jobs (1 to 1 correspondence)
 * @package App\Http\Controllers
 */
class WorkshopJobsController extends Controller
{
    use PriceTrait;
    use JobsTrait;
    
    //// PRIVATE (HELPER) FUNCTIONS ////
    //---------------------------------------------------------------------------------------------------------------//

    /**
     * Check printers that are in use if their print has completed and if so change the status
     */
    private function autoCompleteFinishedPrints(){
        //get printers that are in use
        $printers_busy = Printers::where('in_use','=', 1)->get();
        foreach ($printers_busy as $printer_busy) {
            //complete the prints & jobs and change statuses if prints are completed
            $printer_busy->changePrinterStatus($printers_busy);
        }
    }

    /**
     * get an array of the printers currently available to print on based on users authentication
     * @return array
     */
    private function getAvailablePrinters(){
        if (Auth::check()) {
            // Get the available printers to display in the drop-down.
            // Available for staff are the printers with status Available or Broken that are not in use.
            $available_printers = printers::all()
                ->where('printer_status', '!=', 'Missing')
                ->where('printer_status', '!=', 'On Loan')
                ->where('printer_status', '!=', 'Signed out')
                ->where('in_use', 0)
                ->pluck('id', 'id')->all();
        } else {
            // Get the available printers to display in the drop-down.
            // Available for customers are the printers with status Available that are not in use and not for staff only.
            $available_printers = printers::where('isWorkshop', 1)
                ->where('printer_status', 'Available')
                ->where('in_use', 0)
                ->pluck('id', 'id')->all();
        }
        return $available_printers;
    }

    
    /** gets the counts of jobs in the different steps of the workflow**/
    private function getCounts(){
        $counts = [];
        $count = Jobs::orderBy('created_at', 'desc')->where('status','Waiting')->where('requested_online', 0)->count();
        $counts['pending'] = ($count != 0) ? $count: null;
        $count = Jobs::orderBy('created_at', 'desc')->where('status','Approved')->where('requested_online', 0)->count();
        $counts['approved'] = ($count != 0) ? $count: null;        
        return $counts;
    }

    //// GENERIC PUBLIC FUNCTIONS ////
    //---------------------------------------------------------------------------------------------------------------//
    
    //// CONTROLLER BLADES ////
    //---------------------------------------------------------------------------------------------------------------//

    /**
     * Function to display the blade with all pending jobs
     * Creates variables for blade that displays the Workshop jobs waiting for approval
     * @blade /WorkshopJobs/requests
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getRequests()
    {
        // Check if any non-completed prints exist and autocomplete them
        $this->autoCompleteFinishedPrints();
        // Get all the workshop jobs waiting for approval
        $jobs = Jobs::orderBy('created_at', 'desc')
                        ->where('status','Waiting')
                        ->where('requested_online', 0)
                        ->get();
        $counts = $this->getCounts();
        return view('workshopJobs.index', compact('jobs','counts'));
    }

    /**
     * Return the blade containing all approved (currently printing) workshop jobs
     * @blade /WorkshopJobs/approved
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getApproved()
    {
        $this->autoCompleteFinishedPrints();
        // Get all the approved jobs
        $approved_jobs = Jobs::orderBy('created_at', 'desc')
                            ->where('status','Approved')
                            ->where('requested_online', 0)
                            ->get();
        $counts = $this->getCounts();
        return view('workshopJobs.approved', compact('approved_jobs','counts'));
    }

    /**
     * Return the blade containing all the finished (completed) workshop jobs
     * @blade /WorkshopJobs/finished
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFinished()
    {
        $this->autoCompleteFinishedPrints();
        // Get all the completed jobs from the last 30 days
        $finished_jobs = Jobs::where('created_at', '>=', Carbon::now()->subMonth())
                                ->orderBy('created_at', 'desc')
                                ->where('status','!=', 'Waiting')
                                ->where('status','!=', 'Approved')
                                ->where('requested_online', 0)
                                ->get();
        $counts = $this->getCounts();
        return view('workshopJobs.finished', compact('finished_jobs','counts'));
    }

    /**
     * Return the blade to request a new workshop job
     * @blade /WorkshopJobs/create
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->autoCompleteFinishedPrints();
        // Get the available printers to display in the drop-down.
        $available_printers = $this->getAvailablePrinters();
        // Check the user requesting is authenticated
        if (Auth::check()) {
            // Retain all the information about a member of staff from the DB to use in prepopulation
            $member = Auth::user()->staff;
            if(!$member){
                $customer = Auth::user();
                return view('workshopJobs.create',compact('available_printers','customer'));
            }
            return view('workshopJobs.create',compact('available_printers','member'));
        } else {
            return view('workshopJobs.create',compact('available_printers'));
        }
    }
    
    /**
     * Function to display the blade with the job details waiting for staff approval
     * @blade /WorkshopJobs/<id>
     * @param int $id job id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        //get the job
        $job = Jobs::findOrFail($id);
        //get the available printers if staff wants to change the printer number
        $available_printers = printers::all()
            ->where('printer_status', '!=', 'Missing')
            ->where('printer_status', '!=', 'On Loan')
            ->where('printer_status', '!=', 'Signed out')
            ->pluck('id', 'id')->all();
        //return the blade
        return view('workshopJobs.show',compact('job','available_printers'));
    }
    
    /**
     * Edit the workshop job after it has completed
     * @blade /WorkshopJobs/<id>/edit
     * @param int $id job id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        // Get the job
        $job = Jobs::findOrFail($id);
        // Return the blade
        return view('workshopJobs.edit',compact('job'));
    }

    //// CONTROLLER ACTIONS ////
    //---------------------------------------------------------------------------------------------------------------//

    /**
     * Function to store the request of a new workshop print sent via POST method in the database
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $workshop_request = request()
         
        //get customer name and email
        $workshop_request['customer_name'] = Auth::user()->name();
        $workshop_request['customer_email'] = Auth::user()->email();
        
        // Validate the online request
        $workshop_request = $workshop_request->validate([
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
            'material_amount' => [
                'required',
                'numeric',
                'regex:/^(?!0(\.?0*)?$)\d{0,3}(\.?\d{0,1})?$/'
            ],
            'use_case' => [
                'required',
                new UseCase
            ],
            'budget_holder' => [
                'max:100',
            ],
            'job_title' => [
                'required',
                'string',
                'min:8',
                'max:256'
            ]
        ]);

        // Define payment category
        $payment_category = $this->getPaymentCategory($workshop_request['customer_id']);

        // Get payment details checked
        $temp = $this->getPaymentDetails($workshop_request['use_case'],$workshop_request['budget_holder']);
        $workshop_request['cost_code'] = $temp[0];
        $workshop_request['use_case'] = $temp[1];
        $workshop_request['budget_holder'] = $temp[2];

        // Calculating printing time from the dropdown
        $hours = Input::get('hours');
        $minutes = Input::get('minutes');
        $time = $hours . ':' . sprintf('%02d', $minutes).':00';

        // Get the material amount used
        $material_amount = $workshop_request['material_amount'];

        // Calculate the price for the job
        $price = $this->_getPriceOfJob($hours,$minutes,$material_amount);


        // Get the id of the printer requested
        $printers_id = Input::get('printers_id');


        // Submit the data to the database
        // Create the Job
        $job = Jobs::create(array(
            'paid'                  => 'No',
            'payment_category'      => $payment_category,
            'use_case'              => $workshop_request['use_case'],
            'cost_code'             => $workshop_request['cost_code'],
            'requested_online'      => 0,
            'status'                => 'Waiting',
            'job_title'             => $workshop_request['job_title'],
            'budget_holder'         => $workshop_request['budget_holder'],
            'total_material_amount' => $material_amount,
            'total_price'           => $price,
            'total_duration'        => $time,
            'customer_id'           => $workshop_request['customer_id'],
            'customer_name'         => $workshop_request['customer_name'],
            'customer_email'        => $workshop_request['customer_email']
        ));
        //Create the Print
        $print = new Prints;
        $print -> printers_id = $printers_id;
        $print -> time = $time;
        $print -> material_amount = $material_amount;
        $print -> purpose = 'Use';
        $print -> price = $price;
        $print->save();

        // Associate the print with the job
        $job->prints()->attach($print);

        // Set printer to be "in use"
        printers::where('id','=', Input::get('printers_id'))->update(array('in_use'=> 1));

        // Notification of request acceptance
        notify()->flash('Your job request has been recorded!', 'success', [
            'text' => 'Please ask a demonstrator to approve the job before you start the print.',
        ]);

       // Redirect to home directory
       return redirect('/myprints');
    }

    /**
     * Function called when the workshop print gets approved by a demonstrator
     * @param int $id id of the current print
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id)
    {
        // Do PHP validation
        $workshop_request = request()->validate([
            'student_name' => 'required|string',
            'student_id' => 'required|numeric',
            'email' => 'required|email',
            'material_amount' => 'required|numeric',
        ]);

        // Calculating printing time from the drop-down
        $hours = Input::get('hours');
        $minutes = Input::get('minutes');
        $time = $hours . ':' . sprintf('%02d', $minutes).':00';

        // Get the material amount used
        $material_amount = $workshop_request['material_amount'];

        // Calculate the price for the job
        $price = $this->_getPriceOfJob($hours,$minutes,$material_amount);

        // Submit the data to the database
        $job = Jobs::findOrFail($id);
        $print_id = $job->prints->first()->id;
        // Update the Job
        $job->update([
            'customer_name' => request('student_name'),
            'customer_id' => request('student_id'),
            'customer_email' => request('email'),
            'total_duration' => $time,
            'total_material_amount' => $material_amount,
            'total_price' => $price,
            'accepted_at' => Carbon::now('Europe/London'),
            'requested_online' => 0
        ]);
        // Approve job
        $job->approve(request('comments'));
        
        // Update the Print
        $print = Prints::findOrFail($print_id);
        $print->update([
            'printers_id' => Input::get('printers_id'),
            'time' => $time,
            'material_amount' => $material_amount,
            'price' => $price
        ]);
        // Approve print
        $print->approve();

        // Display notification to user
        notify()->flash('The job has been successfully approved!', 'success', [
            'text' => 'The student may start printing now',
        ]);

        // Redirect to Pending Jobs blade
        return redirect('WorkshopJobs/requests');
    }

    /**
     * marks a job as failed
     * @blade_address /workshopJobs/abort/<id>
     * @param int $id job id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function abort($id)
    {
        if(!$print->status === "Approved" || !$job->status === "Approved"){
            // Notify user in case this was an old job
            notify()->flash('It looks like someone was faster than you.', 'error', [
                'text' => "Please refresh the page and continue as normal.",
            ]);
            return redirect('WorkshopJobs/requests');
        }        
        
        //Set the price to 0
        $new_price = 0;

        // Submit the data to the database
        $job = Jobs::findOrFail($id);
        $print_id = $job->prints->first()->id;
        $print = Prints::findOrFail($print_id);
        // Update Job
        $job->update([
            'total_price' => $new_price
            ]);
        $job->finish("Failed");
        // Update Print
        $print->update([
            'price' => $new_price
        ]);
        $print->finish("Failed");

        // Notify user
        notify()->flash('The job has been marked as Failed!', 'success', [
            'text' => "If this was not reported by {$job->customer_name}, please contact the customer via {$job->customer_email}.",
        ]);

        // Redirect to blade showing currently printing jobs
        return redirect('WorkshopJobs/approved');
    }

    /**
     * marks job as successful
     * @param int $id job id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function success($id)
    {
        //get the job and related print
        $job = Jobs::findOrFail($id);
        $print_id = $job->prints->first()->id;
        $print = Prints::findOrFail($print_id);
        //need to first check if this job is currently printing or not.
        if(!$print->status === "Approved" || !$job->status === "Approved"){
            // Notify user in case this was an old job
            notify()->flash('It looks like someone was faster than you.', 'error', [
                'text' => "Please refresh the page and continue as normal.",
            ]);
            return redirect('WorkshopJobs/requests');
        }
        
        // Mark printer as available
        printers::where('id', '=', $print->printers_id)->update(array('in_use' => 0));
        // Mark job as successful
        $job->finish("Success");
        // Mark print as successful
        $print->finish("Success");
        
        // Notify user
        notify()->flash('The job has been marked as Success!', 'success', [
            'text' => "You may continue reviewing other jobs.",
        ]);
        
        // Redirect to blade showing currently printing jobs
        return redirect('WorkshopJobs/approved');
    }
    
    /**
     * Function that updates the job details
     * @param int $id job id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function review($id)
    {
        // Do PHP validation
        $this -> validate(request(), [
            'material_amount' => 'required|numeric',
            'successful' => 'required'
        ]);

        // Calculating printing time from the dropdown
        $hours = Input::get('hours');
        $minutes = Input::get('minutes');
        $time = $hours . ':' . sprintf('%02d', $minutes).':00';

        // Get the material amount used
        $material_amount = request('material_amount');

        // Calculate the price for the job
        if (request('successful') == 'Failed') {
            $price = 0;
        } else {
            $price = $this->_getPriceOfJob($hours,$minutes,$material_amount);
        }

        // Submit the data to the database
        $job = Jobs::findOrFail($id);
        $print_id = $job->prints->first()->id;
        $print = Prints::findOrFail($print_id);
        // Update Job
        $job->update([
            'total_duration' => $time,
            'total_material_amount' => $material_amount,
            'total_price' => $price,
            'status'=> request('successful'),
            'job_finished_by' => Auth::user()->staff->id
        ]);
        // Update print
        $print->update([
            'time' => $time,
            'material_amount' => $material_amount,
            'price' => $price,
            'status' => request('successful'),
            'print_finished_by' => Auth::user()->staff->id
        ]);

        // Notify user
        notify()->flash('The job details have been updated', 'success', [
            'text' => "If this was unintentional then please change it back :)",
        ]);
        // Redirect to blade with completed workshop jobs
        return redirect('WorkshopJobs/finished');
    }

    /**
     * rejects a workshop job before printing started
     * @param int $id job id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        //get the job and related print
        $job = Jobs::findOrFail($id);
        $print_id = $job->prints->first()->id;
        $print = Prints::findOrFail($print_id);
        //mark the printer as available again
        printers::where('id','=', $print->printers_id)->update(array('in_use'=> 0));
        //delete job-print connection, delete job and delete print
        $job->prints()->detach($print_id);
        $job->delete();
        $print->delete();
        //notify user
        notify()->flash('The job has been rejected!', 'success', [
            'text' => "Please contact the student {$job->customer_name} with printer {$print->printers_id}.",
        ]);
        // redirect to list of newly requested jobs waiting for approval
        return redirect('WorkshopJobs/requests');
    }

    /**
     * restarts a workshop job by pre-populating the request form
     * @param int $id job id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function restart($id)
    {
        // Get job data
        $data = Jobs::findOrFail($id);

        // Get the available printers to display in the drop-down.
        $available_printers = $this->getAvailablePrinters();

        // Show request form and pass it the pre-population data
        return view('workshopJobs.create',compact('available_printers','data'));
    }
}
