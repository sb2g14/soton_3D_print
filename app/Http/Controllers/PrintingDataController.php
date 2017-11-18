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

class PrintingDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobs = Jobs::orderBy('created_at', 'desc')->where('status','Waiting')->where('requested_online', 0)->get();
        return view('printingData.index', compact('jobs'));
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

    public function approved()
    {
        $approved_jobs = Jobs::orderBy('created_at', 'desc')->where('status','Approved')->get();
        return view('printingData.approved', compact('approved_jobs'));
    }

    public function finished()
    {
        $finished_jobs = Jobs::where('created_at', '>=', Carbon::now()->subMonth())->orderBy('created_at', 'desc')->where('status','!=', 'Waiting')->get();

        return view('printingData.finished', compact('finished_jobs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check if all current jobs are finished
        $printers_busy = Printers::where('in_use','=', 1)->get();
        foreach ($printers_busy as $printer_busy) {
            $printer_busy->changePrinterStatus($printers_busy);
        }

    if (Auth::check()) {
        if (Auth::user()->hasRole('OnlineJobsManager')) {
            $available_printers = printers::all()->where('printer_status', '!=', 'Missing')->where('printer_status', '!=', 'On Loan')->where('printer_status', '!=', 'Signed out')->pluck('id', 'id')->all();
        } else {
            $available_printers = printers::all()->where('printer_status', '!=', 'Missing')->where('printer_status', '!=', 'On Loan')->where('printer_status', '!=', 'Signed out')->where('in_use', 0)->pluck('id', 'id')->all();
        }
        if (!Auth::user()->hasRole('OnlineJobsManager')) {
            $member = Auth::user()->staff;
        }
        return view('printingData.create',compact('available_printers','member'));
    } else {
        $available_printers = printers::where('printer_status', 'Available')->where('in_use', 0)->where('printer_type', '!=', 'UP BOX')->pluck('id', 'id')->all();
        return view('printingData.create',compact('available_printers'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate(request(), [
            'student_name' => 'required|string|min:3|max:100|regex:/^[a-z ,.\'-]+$/i',
            'email' => 'required|email|min:3|max:30|regex:/^([a-zA-Z0-9_.+-])+\@soton.ac.uk$/',
            'student_id' => 'required|numeric|min:8',
            'material_amount' => 'required|numeric|min:1|regex:/^(?!0(\.?0*)?$)\d{0,3}(\.?\d{0,1})?$/',
            'use_case' => 'required|min:3'
        ]);
        if (Auth::check()) {
            $shortages = cost_code::all()->pluck('shortage', 'id')->toArray();
            $shortages = array_map('strtolower', $shortages);
            $cost_codes = cost_code::all()->pluck('cost_code', 'id')->toArray();
        } else {
            $shortages = cost_code::where('shortage', '!=', 'Demonstrator')->pluck('shortage', 'id')->toArray();
            $shortages = array_map('strtolower', $shortages);
            $cost_codes = cost_code::where('shortage', '!=', 'Demonstrator')->pluck('cost_code', 'id')->toArray();
        }
        // $cost_codes = $cost_codes->toArray();
        $use_case = strtolower(request('use_case'));
        if( in_array($use_case, $shortages)) {

            // Update record in staff database in order to link with users database
            $shortage_id = array_search($use_case, $shortages);
            $cost_code = cost_code::where('id', $shortage_id)->first()->cost_code;

        } elseif(preg_match('/^(\d{9,10})$/', $use_case) === 1) {
        $cost_code = (int)$use_case;
            if (in_array($cost_code, $cost_codes)){
            $use_case = 'Cost Code - approved';
            } else {
                $use_case = 'Cost Code - unknown';
            }
        } else {
            session()->flash('message', 'Please check the module name or enter a valid cost code');
            return redirect('printingData/create')->withInput();
        }

        // Calculating printing time from the dropdown
        $hours = Input::get('hours');
        $minutes = Input::get('minutes');
        $time = $hours . ':' . sprintf('%02d', $minutes);

        $material_amount = request('material_amount');
        // Calculation the job price £3 per h + £5 per 100g
        $price = round(3 * ($hours + $minutes / 60) + 5 * $material_amount / 100, 2);

        // Request id and identify the payment category
        $student_id = request('student_id');
        if (substr($student_id, 0, 1) == '1') {
            $payment_category = 'staff';
        } elseif (substr($student_id, 0, 1) == '2') {
            $payment_category = 'postgraduate';
        } elseif (substr($student_id, 0, 1) == '3') {
            $payment_category = 'masters';
        } else {
            $payment_category = 'undergraduate';
        }
        // Printer requested
        $printers_id = Input::get('printers_id');

        // Submit the data to the database

        $job = new Jobs;

         $job -> total_material_amount = $material_amount;
         $job -> total_price = $price;
         $job -> total_duration = $time;
         $job -> paid = 'No';
         $job -> payment_category = $payment_category;
         $job -> cost_code = $cost_code;
         $job -> use_case = $use_case;
         $job -> customer_id = $student_id;
         $job -> customer_name = request('student_name');
         $job -> customer_email = request('email');
         $job -> requested_online = 0;

         $job->save();

        $print = new Prints;

        $print -> printers_id = $printers_id;
        $print -> time = $time;
        $print -> material_amount = $material_amount;
        $print -> purpose = 'Use';
        $print -> price = $price;

        $print->save();

        $job_print = new JobsPrints;

        $job_print -> jobs_id = $job->id;
        $job_print -> prints_id = $print->id;

        $job_print->save();

        printers::where('id','=', Input::get('printers_id'))->update(array('in_use'=> 1));

        // Notification of request acceptance
        notify()->flash('Your job request has been accepted!', 'success', [
            'text' => 'Please ask a demonstrator to approve the job before you start the print.',
        ]);

       // Redirect to home directory
       return redirect()->home();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        $job = printing_data::find($id);
        $job = Jobs::findOrFail($id);
        $available_printers = printers::all()->where('printer_status', '!=', 'Missing')->where('printer_status', '!=', 'On Loan')->where('printer_status', '!=', 'Signed out')->pluck('id', 'id')->all();
        return view('printingData.show',compact('job','available_printers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $this -> validate(request(), [
            'student_name' => 'required|string',
            'student_id' => 'required|numeric',
            'email' => 'required|email',
            'material_amount' => 'required|numeric',
        ]);
//        $staff_id = Auth::user()->id;
//        dd(request()->all(), $staff_id, $id);
//        $data = printing_data::findOrFail($id);

        $hours = Input::get('hours');
        $minutes = Input::get('minutes');
        $time = $hours.':'.sprintf('%02d', $minutes);
        $material_amount = request('material_amount');
        $price = round(3 * ($hours + $minutes / 60) + 5 * $material_amount / 100, 2);

        $job = Jobs::findOrFail($id);
        $print_id = $job->prints->first()->id;
        $job->update([
            'customer_name' => request('student_name'),
            'customer_id' => request('student_id'),
            'customer_email' => request('email'),
            'total_duration' => $time,
            'total_material_amount' => $material_amount,
            'total_price' => $price,
            'job_approved_comment' => request('comments'),
            'job_approved_by' => Auth::user()->staff->id,
            'job_finished_by' => Auth::user()->staff->id,
            'approved_at' => Carbon::now('Europe/London'),
            'requested_online' => 0,
            'status' => 'Approved',
        ]);
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

        session()->flash('message', 'The job has been successfully approved!');

        return redirect('printingData/index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $job = Jobs::findOrFail($id);
        return view('printingData.edit',compact('job'));
    }

    public function review($id)
    {
        $this -> validate(request(), [
            'material_amount' => 'required|numeric',
            'successful' => 'required'
        ]);
        $job = Jobs::findOrFail($id);
        $print_id = $job->prints->first()->id;
        $print = Prints::findOrFail($print_id);

        $hours = Input::get('hours');
        $minutes = Input::get('minutes');
        $time = $hours.':'.sprintf('%02d', $minutes);
        $material_amount =request('material_amount');

        if (request('successful') == 'Failed') {
            $price = 0;
        } else {
            $price = round(3 * ($hours + $minutes / 60) + 5 * $material_amount / 100, 2);
        }

//        Condition for 3Dhubs manager only
//        if (Auth::user()->hasRole('OnlineJobsManager')) {
//            if (request('successful') == 'No') {
//                $price = 0;
//            } else {
//                $price = round(3 * ($hours + $minutes / 60) + 5 * $material_amount / 100, 2);
//            }
//        } else {
//            // Calculation the job price £3 per h + £5 per 100g
//            $price = round(3 * ($hours + $minutes / 60) + 5 * $material_amount / 100, 2);
//        }

        $job->update([
            'total_duration' => $time,
            'total_material_amount' => $material_amount,
            'total_price' => $price,
            'status'=> request('successful'),
        ]);
        $print->update([
            'time' => $time,
            'material_amount' => $material_amount,
            'price' => $price,
            'status' => request('successful'),
        ]);

        session()->flash('message', 'The job has been revised!');
        return redirect('printingData/finished');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function abort($id)
{
    $job = Jobs::findOrFail($id);
    $print_id = $job->prints->first()->id;
    $print = Prints::findOrFail($print_id);
    $now = Carbon::now('Europe/London');
    //$time = time() - strtotime($data->updated_at);
    //$hours = date('H', $time);
    //$minutes = date('i', $time);
    $hours = $now->diffInHours($job->created_at);
    $minutes = $now->diffInMinutes($job->created_at) - $hours*60;
    $new_time = $hours.':'.sprintf('%02d', $minutes);
    $new_price = 0;

//    Condition to reduce price only for 3Dhubs manager
//    if (Auth::user()->hasRole('OnlineJobsManager')) {
//        $new_price = 0;
//    } else {
//        $new_price = round(3 * ($hours + $minutes / 60), 2);
//    }
    $job->update(['status'=>'Failed',
        'total_duration' => $new_time,
        'total_price' => $new_price
        ]);
    $print->update([
        'time' => $new_time,
        'price' => $new_price,
        'status' => 'Failed',
    ]);


    printers::where('id','=', $print->printers_id)->update(array('in_use'=> 0));

    session()->flash('message', 'The job has been canceled');

    return redirect('printingData/index');
}
    public function success($id)
    {
        Jobs::where('id','=',$id)->update(array('status'=> 'Success'));
        $job = Jobs::findOrFail($id);
        $print_id = $job->prints->first()->id;
        $print = Prints::findOrFail($print_id);
        printers::where('id','=', $print->printers_id)->update(array('in_use'=> 0));

        session()->flash('message', 'The job is successful');

        return redirect('printingData/index');
    }
    public function destroy($id)
    {
        $job = Jobs::findOrFail($id);
        $print_id = $job->prints->first()->id;
        $print = Prints::findOrFail($print_id);
        printers::where('id','=', $print->printers_id)->update(array('in_use'=> 0));
        $job->prints()->detach($print_id);
        $job->delete();
        $print->delete();

        session()->flash('message', 'The job has been rejected');

        return redirect('printingData/index');
    }
    public function restart($id)
    {
        $data = Jobs::findOrFail($id);

        if (Auth::user()->hasRole('OnlineJobsManager')) {
            $available_printers = printers::all()->where('printer_status', '!=', 'Missing')->where('printer_status', '!=', 'On Loan')->where('printer_status', '!=', 'Signed out')->pluck('id', 'id')->all();
        } else {
            $available_printers = printers::all()->where('printer_status', '!=', 'Missing')->where('printer_status', '!=', 'On Loan')->where('printer_status', '!=', 'Signed out')->where('in_use', 0)->pluck('id', 'id')->all();
        }

        return view('printingData.create',compact('available_printers','data'));
    }
}
