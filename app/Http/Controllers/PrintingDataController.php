<?php

namespace App\Http\Controllers;

use App\JobsPrints;
use App\printers;
use Illuminate\Http\Request;
use App\Jobs;
use App\Prints;
use App\cost_code;
use Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules\In;
use Excel;
use Carbon\Carbon;

use App\Rules\Alphanumeric;
use App\Rules\SotonEmail;
use App\Rules\SotonID;
use App\Rules\SotonIdMinMax;
use App\Rules\UseCase;
use App\Rules\CustomerNameValidation;

/**
 * This controller manages workshop prints and jobs
 * in this scenario 1 job = 1 print
 */

class PrintingDataController extends Controller
{
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

    /**
     * Defines the payment category based on the 9 digit uni id
     * @param $customer_id string
     * @return string
     */
    private function getPaymentCategory($customer_id){
        $firstdigit = substr($customer_id, 0, 1);
        switch ($firstdigit) {
            case '1':
                $payment_category = 'staff';
                break;
            case '2':
                $payment_category = 'postgraduate';
                break;
            case '3':
                $payment_category = 'masters';
                break;
            default:
                $payment_category = 'undergraduate';
                break;
        }
        return $payment_category;
    }

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

    /**
     * checks the payment details and returns the corrected details
     * takes a shortage or costcode as $use_case and the $budget_holder
     * returns the use_case as shortage or known/unknown cost code,
     * looks up the shortage/ cost code in the database and returns the
     * data from the database if found. Returns the provided data otherwise
     * @param $use_case string
     * @param $budget_holder string
     * @return array $cost_code, $use_case, $budget_holder
     */
    private function getPaymentDetails($use_case,$budget_holder){
        // Define a cost code
        // check the module shortage exists
        $query = cost_code::all()->where('shortage','=',strtoupper($use_case))->first();
        if ($query !== null){
            // If shortage exists, then populate cost code and shortage with the DB data
            $cost_code = $query->value('cost_code');
            $use_case = strtoupper($use_case);
            $budget_holder = $query->holder;
        } else { // If shortage is not found in the DB, check whether the cost code can be found in the DB
            $query = cost_code::all()->where('cost_code','=',$use_case)->first();
            $cost_code = $use_case;
            if ($query !== null){ // The cost code was found. Set a corresponding flag
                $use_case = 'Cost Code - approved';
                $budget_holder = $query->holder;
            } else { // The cost code was not found. Set a corresponding flag
                $use_case = 'Cost Code - unknown';
                //$budget_holder = $budget_holder;
            }
        }
        return [$cost_code, $use_case, $budget_holder];
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

    /**
     * Function to display the blade with all pending jobs
     * Creates variables for blade that displays the Workshop jobs waiting for approval
     * @blade_address /printingData/index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // Check if any non-completed prints exist and autocomplete them
        $this->autoCompleteFinishedPrints();
        // Get all the workshop jobs waiting for approval
        $jobs = Jobs::orderBy('created_at', 'desc')->where('status','Waiting')->where('requested_online', 0)->get();
        $counts = $this->getCounts();
        return view('printingData.index', compact('jobs','counts'));
    }

    /**
     * Return the blade containing all approved (currently printing) workshop jobs
     * @blade_address /printingData/approved
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function approved()
    {
        $this->autoCompleteFinishedPrints();
        // Get all the approved jobs
        $approved_jobs = Jobs::orderBy('created_at', 'desc')->where('status','Approved')->where('requested_online', 0)->get();
        $counts = $this->getCounts();
        return view('printingData.approved', compact('approved_jobs','counts'));
    }

    /**
     * Return the blade containing all the finished (completed) workshop jobs
     * @blade_address /printingData/finished
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finished()
    {
        $this->autoCompleteFinishedPrints();
        // Get all the completed jobs from the last 30 days
        $finished_jobs = Jobs::where('created_at', '>=', Carbon::now()->subMonth())->orderBy('created_at', 'desc')->where('status','!=', 'Waiting')->where('requested_online', 0)->get();
        $counts = $this->getCounts();
        return view('printingData.finished', compact('finished_jobs','counts'));
    }

    /**
     * Return the blade to request a new workshop job
     * @blade_address /printingData/create
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
            return view('printingData.create',compact('available_printers','member'));
        } else {
            return view('printingData.create',compact('available_printers'));
        }
    }



    /**
     * Function to store the request of a new workshop sent via POST method
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        // Validate the online request
        $workshop_request = request()->validate([
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
        $customer_id = $workshop_request['customer_id'];
        $payment_category = $this->getPaymentCategory($customer_id);

        // Get payment details checked
        $temp = $this->getPaymentDetails($workshop_request['use_case'],$workshop_request['budget_holder']);
        $cost_code = $temp[0];
        $use_case = $temp[1];
        $budget_holder = $temp[2];

        // Calculating printing time from the dropdown
        $hours = Input::get('hours');
        $minutes = Input::get('minutes');
        $time = $hours . ':' . sprintf('%02d', $minutes).':00';

        // Get the material amount used
        $material_amount = $workshop_request['material_amount'];

        // Calculate the price for the job
        $price = $this->getPriceOfJob($hours,$minutes,$material_amount);


        // Get the id of the printer requested
        $printers_id = Input::get('printers_id');


        // Submit the data to the database
        // Create the Job
        $job = Jobs::create(array(
            'paid'=> 'No',
            'payment_category' => $payment_category,
            'use_case' => $use_case,
            'cost_code' => $cost_code,
            'requested_online' => 0,
            'status' => 'Waiting',
            'job_title' => $workshop_request['job_title'],
            'budget_holder' => $budget_holder,
            'total_material_amount' => $material_amount,
            'total_price' => $price,
            'total_duration' => $time,
            'customer_id' => $customer_id,
            'customer_name' => $workshop_request['customer_name'],
            'customer_email' => $workshop_request['customer_email']
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
        notify()->flash('Your job request has been accepted!', 'success', [
            'text' => 'Please ask a demonstrator to approve the job before you start the print.',
        ]);

       // Redirect to home directory
       return redirect()->home();
    }

    /**
     * Function to display the blade with the job details waiting for staff approval
     * @blade_address /printingData/show/<id>
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        //get the job
        $job = Jobs::findOrFail($id);
        //get the available printers if staff wants to change the printer number
        $available_printers = printers::all()->where('printer_status', '!=', 'Missing')->where('printer_status', '!=', 'On Loan')->where('printer_status', '!=', 'Signed out')->pluck('id', 'id')->all();
        //return the blade
        return view('printingData.show',compact('job','available_printers'));
    }

    /**
     * Function called when the workshop print gets approved by a demonstrator
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id)
    {
        // Do PHP validation
        //TODO: check which one of the two lines below is better
        //$this -> validate(request(), [
        $workshop_request = request()->validate([
            'student_name' => 'required|string',
            'student_id' => 'required|numeric',
            'email' => 'required|email',
            'material_amount' => 'required|numeric',
        ]);


        // Calculating printing time from the dropdown
        $hours = Input::get('hours');
        $minutes = Input::get('minutes');
        $time = $hours . ':' . sprintf('%02d', $minutes).':00';

        // Get the material amount used
        $material_amount = $workshop_request['material_amount'];

        // Calculate the price for the job
        $price = $this->getPriceOfJob($hours,$minutes,$material_amount);

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
            'job_approved_comment' => request('comments'),
            'job_approved_by' => Auth::user()->staff->id,
            'approved_at' => Carbon::now('Europe/London'),
            'requested_online' => 0,
            'status' => 'Approved',
        ]);
        // Update the Print
        $print = Prints::findOrFail($print_id);
        $print->update([
            'printers_id' => Input::get('printers_id'),
            'time' => $time,
            'material_amount' => $material_amount,
            'price' => $price,
            'status' => 'Approved',
            'print_started_by' => Auth::user()->staff->id,
            'print_finished_by' => Auth::user()->staff->id,
        ]);

        // Display notification to user
        notify()->flash('The job has been successfully approved!', 'success', [
            'text' => 'The student may start printing now',
        ]);

        // Redirect to Pending Jobs blade
        return redirect('printingData/index');
    }

    /**
     * Edit the workshop job after it has completed
     * @blade_address /printingData/edit/<id>
     * @param $id int
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        // Get the job
        $job = Jobs::findOrFail($id);
        // Return the blade
        return view('printingData.edit',compact('job'));
    }

    /**
     * Function that updates the job details
     * @param $id
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
            $price = $this->getPriceOfJob($hours,$minutes,$material_amount);
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
        return redirect('printingData/finished');
    }

    /**
     * marks a job as failed
     * @blade_address /printingData/abort/<id>
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function abort($id)
    {
        //Set the price to 0
        $new_price = 0;

        // Submit the data to the database
        $job = Jobs::findOrFail($id);
        $print_id = $job->prints->first()->id;
        $print = Prints::findOrFail($print_id);
        // Update Job
        $job->update([
            'status'=>'Failed',
            'total_price' => $new_price,
            'job_finished_by' => Auth::user()->staff->id
            ]);
        // Update Print
        $print->update([
            'status' => 'Failed',
            'price' => $new_price,
            'print_finished_by' => Auth::user()->staff->id
        ]);

        // Mark printer to be available again
        printers::where('id','=', $print->printers_id)->update(array('in_use'=> 0));

        // Notify user
        notify()->flash('The job has been marked as Failed!', 'success', [
            'text' => "If this was not reported by {$job->customer_name}, please contact the customer via {$job->customer_email}.",
        ]);

        // Redirect to blade showing currently printing jobs
        return redirect('printingData/approved');
    }

    /**
     * marks job as successful
     * @param $id int
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
            //notify user in case this was an old job
            notify()->flash('It looks like someone was faster than you.', 'error', [
                'text' => "Please refresh the page and continue as normal.",
            ]);
        }else {
            //mark printer as available
            printers::where('id', '=', $print->printers_id)->update(array('in_use' => 0));
            //mark job as successful
            $job->update(array('job_finished_by' => Auth::user()->staff->id, 'status' => 'Success'));
            //mark print as successful
            $print->update(array('print_finished_by' => Auth::user()->staff->id, 'status' => 'Success'));
            //notify user
            notify()->flash('The job has been marked as Success!', 'success', [
                'text' => "You may continue reviewing other jobs.",
            ]);
        }
        //redirect to blade showing currently printing jobs
        return redirect('printingData/approved');
    }

    /**
     * rejects a workshop job before printing started
     * @param $id int
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
        return redirect('printingData/index');
    }

    /**
     * restarts a workshop job by pre-populating the request form
     * @param $id int
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function restart($id)
    {
        // Get job data
        $data = Jobs::findOrFail($id);

        // Get the available printers to display in the drop-down.
        $available_printers = $this->getAvailablePrinters();

        // Show request form and pass it the pre-population data
        return view('printingData.create',compact('available_printers','data'));
    }

    //    public function printingDataExport()
//    {
//
//        // Get all jobs
//        $jobs = printing_data::select('printers_id','serial_no','created_at','purpose','student_name','student_id','time','material_amount','price','paid','approved_name','payment_category','use_case','cost_code','add_comment','month','id','successful','email')->get();
//
//
//        // Initialize the array which will be passed into the Excel
//        // generator.
//        $jobsArray = [];
//
//        // Define the Excel spreadsheet headers
//        $jobsArray[] = ['Printer No Common', 'Printer No','Date','Use/Loan','Student Name','Student ID','Time','Material Amount','Price','Paid','Demonstrator Sign','Payment Category', 'Use Case','Cost Code','Comment','Month','Jobs No','Successful?','Email'];
//
//        // Convert each member of the returned collection into an array,
//        // and append it to the payments array.
//        foreach ($jobs as $job) {
//            $jobsArray[] = $job->toArray();
//        }
//
//        // Generate and return the spreadsheet
//        Excel::create('PrintingData', function($excel) use ($jobsArray) {
//
//            // Set the spreadsheet title, creator, and description
//            $excel->setTitle('printing_data');
//            $excel->setCreator(Auth::user()->name)->setCompany('3D printing workshop');
//            $excel->setDescription('Excel file used as a backup for information about printing jobs in the 3D printing workshop at University of Southampton');
//
//            // Build the spreadsheet, passing in the payments array
//            $excel->sheet('sheet1', function($sheet) use ($jobsArray) {
//                $sheet->fromArray($jobsArray, null, 'A1', false, false);
//            });
//
//        })->download('xlsx');
//    }
}
