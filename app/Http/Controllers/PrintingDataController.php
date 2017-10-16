<?php

namespace App\Http\Controllers;

use App\printers;
use Illuminate\Http\Request;
use App\printing_data;
use App\cost_code;
use Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules\In;
use Excel;
use Carbon\Carbon;

class PrintingDataController extends Controller
{
//    public function __construct()
//    {
//
//        $this->middleware('auth')->except(['create','store']);
//
//    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobs =  printing_data::where('approved', 'Waiting')->get();
        return view('printingData.index', compact('jobs'));
    }

    public function printingDataExport()
    {

        // Get all jobs
        $jobs = printing_data::select('printers_id','serial_no','created_at','purpose','student_name','student_id','time','material_amount','price','paid','approved_name','payment_category','use_case','cost_code','add_comment','month','id','successful','email')->get();


        // Initialize the array which will be passed into the Excel
        // generator.
        $jobsArray = [];

        // Define the Excel spreadsheet headers
        $jobsArray[] = ['Printer No Common', 'Printer No','Date','Use/Loan','Student Name','Student ID','Time','Material Amount','Price','Paid','Demonstrator Sign','Payment Category', 'Use Case','Cost Code','Comment','Month','Job No','Successful?','Email'];

        // Convert each member of the returned collection into an array,
        // and append it to the payments array.
        foreach ($jobs as $job) {
            $jobsArray[] = $job->toArray();
        }

        // Generate and return the spreadsheet
        Excel::create('PrintingData', function($excel) use ($jobsArray) {

            // Set the spreadsheet title, creator, and description
            $excel->setTitle('printing_data');
            $excel->setCreator(Auth::user()->name)->setCompany('3D printing workshop');
            $excel->setDescription('Excel file used as a backup for information about printing jobs in the 3D printing workshop at University of Southampton');

            // Build the spreadsheet, passing in the payments array
            $excel->sheet('sheet1', function($sheet) use ($jobsArray) {
                $sheet->fromArray($jobsArray, null, 'A1', false, false);
            });

        })->download('xlsx');
    }

    public function approved()
    {
        $approved_jobs = printing_data::orderBy('created_at', 'desc')->where('approved', 'Yes')->get();
        return view('printingData.approved', compact('approved_jobs'));
    }

    public function finished()
    {
        $finished_jobs = printing_data::orderBy('created_at', 'desc')->where('approved','!=', 'Waiting')->get();
//        foreach ($jobs as $job)
//        {
//            list($h, $i, $s) = explode(':', $job->time);
//            if (Carbon::now('Europe/London')->gte($job->updated_at->addHour($h)->addMinutes($i))) {
//                $finished_jobs = $finished_jobs->push($job);
//            }
//        }
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
        if (Auth::user()->hasRole('3dhubs_manager')) {
            $available_printers = printers::all()->where('printer_status', '!=', 'Missing')->where('printer_status', '!=', 'On Loan')->where('printer_status', '!=', 'Signed out')->pluck('id', 'id')->all();
        } else {
            $available_printers = printers::all()->where('printer_status', '!=', 'Missing')->where('printer_status', '!=', 'On Loan')->where('printer_status', '!=', 'Signed out')->where('in_use', 0)->pluck('id', 'id')->all();
        }
        if (!Auth::user()->hasRole('3dhubs_manager')) {
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
            'student_name' => 'required|string|min:3|max:100|regex:/[\w\-\'\s]+/',
            'email' => 'required|email|min:3|max:30|regex:/^([a-zA-Z0-9_.+-])+\@soton.ac.uk$/',
            'student_id' => 'required|numeric|min:8',
            'material_amount' => 'required|numeric|min:1|regex:/^(?!0(\.?0*)?$)\d{0,3}(\.?\d{0,1})?$/',
            'use_case' => 'required|min:3'
        ]);
        if (Auth::check()) {
            $shortages = cost_code::all()->pluck('shortage', 'id')->toArray();
            $cost_codes = cost_code::all()->pluck('cost_code', 'id')->toArray();
        } else {
            $shortages = cost_code::where('shortage', '!=', 'Demonstrator')->pluck('shortage', 'id')->toArray();
            $cost_codes = cost_code::where('shortage', '!=', 'Demonstrator')->pluck('cost_code', 'id')->toArray();
        }
        // $cost_codes = $cost_codes->toArray();
        $use_case = request('use_case');
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
        // Year and month of print
        $year =  (string)Carbon::now('Europe/London')->year;
        $month = (string)Carbon::now('Europe/London')->month;
        $yearMonth = $year.'/'.$month;
       printing_data::create([
           'printers_id' => $printers_id,
           'serial_no' => printers::where('id', $printers_id)->first()->serial_no,
           'student_name' => request('student_name'),
           'student_id' => $student_id,
           'payment_category' => $payment_category,
           'email' => request('email'),
           'use_case' => $use_case,
           'cost_code' => $cost_code,
           'time' => $time,
           'price'=> $price,
           'material_amount' => $material_amount,
           'month' =>$yearMonth
       ]);

        printers::where('id','=', Input::get('printers_id'))->update(array('in_use'=> 1));

       // Show flashing message
       session()->flash('message', 'Your job request has been successfully accepted!');
       session()->flash('alert-class', 'alert-success');

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
        $job = printing_data::find($id);
        $available_printers = printers::all()->where('printer_status', '!=', 'Missing')->where('printer_status', '!=', 'On Loan')->where('printer_status', '!=', 'Signed out')->pluck('id', 'id')->all();
        return view('printingData.show',compact('job','available_printers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $job = printing_data::findOrFail($id);
        return view('printingData.edit',compact('job'));
    }

    public function review($id)
    {
        $this -> validate(request(), [
            'material_amount' => 'required|numeric',
            'successful' => 'required'
        ]);
        $data = printing_data::findOrFail($id);

        $hours = Input::get('hours');
        $minutes = Input::get('minutes');
        $time = $hours.':'.sprintf('%02d', $minutes);
        $material_amount =request('material_amount');

        if (request('successful') == 'No') {
                $price = 0;
        } else {
                $price = round(3 * ($hours + $minutes / 60) + 5 * $material_amount / 100, 2);
        }

//        Condition for 3Dhubs manager only
//        if (Auth::user()->hasRole('3dhubs_manager')) {
//            if (request('successful') == 'No') {
//                $price = 0;
//            } else {
//                $price = round(3 * ($hours + $minutes / 60) + 5 * $material_amount / 100, 2);
//            }
//        } else {
//            // Calculation the job price £3 per h + £5 per 100g
//            $price = round(3 * ($hours + $minutes / 60) + 5 * $material_amount / 100, 2);
//        }

        $data->update([
            'time' => $time,
            'material_amount' => $material_amount,
            'price' => $price,
            'successful'=> request('successful'),
        ]);

        session()->flash('message', 'The job has been revised!');
        return redirect('printingData/finished');
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
//       dd(request()->all(), $staff_id, $id);
        $data = printing_data::findOrFail($id);

        $hours = Input::get('hours');
        $minutes = Input::get('minutes');
        $time = $hours.':'.sprintf('%02d', $minutes);

        $data->update([
            'printers_id' => Input::get('printers_id'),
            'student_name' => request('student_name'),
            'student_id' => request('student_id'),
            'email' => request('email'),
            'time' => $time,
            'material_amount' => request('material_amount'),
            'add_comment' => request('comments'),
            'paid' => 'No',
            'purpose' => 'Use',
            'user_id' => Auth::user()->id,
            'approved_name'=>Auth::user()->name,
            'approved' => 'Yes'
        ]);

        session()->flash('message', 'The job has been successfully approved!');

        return redirect('printingData/index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function abort($id)
{
    $data = printing_data::findOrFail($id);
    $now = Carbon::now('Europe/London');
    //$time = time() - strtotime($data->updated_at);
    //$hours = date('H', $time);
    //$minutes = date('i', $time);
    $hours = $now->diffInHours($data->created_at);
    $minutes = $now->diffInMinutes($data->created_at) - $hours*60;
    $new_time = $hours.':'.sprintf('%02d', $minutes);
    $new_price = 0;

//    Condition to reduce price only for 3Dhubs manager
//    if (Auth::user()->hasRole('3dhubs_manager')) {
//        $new_price = 0;
//    } else {
//        $new_price = round(3 * ($hours + $minutes / 60), 2);
//    }
    $data->update(['successful'=>'No',
        'approved'=>'No',
        'time' => $new_time,
        'price' => $new_price
        ]);

    printers::where('id','=', $data->printers_id)->update(array('in_use'=> 0));

    session()->flash('message', 'The job has been canceled');

    return redirect('printingData/index');
}
    public function success($id)
    {
        printing_data::where('id','=',$id)->update(array('approved'=> 'Success'));
        $data = printing_data::findOrFail($id);
        printers::where('id','=', $data->printers_id)->update(array('in_use'=> 0));

        session()->flash('message', 'The job is successful');

        return redirect('printingData/index');
    }
    public function destroy($id)
    {
        $data = printing_data::findOrFail($id);
        printers::where('id','=', $data->printers_id)->update(array('in_use'=> 0));
        $data->delete();

        session()->flash('message', 'The job has been rejected');

        return redirect('printingData/index');
    }
    public function restart($id)
    {
        $data = printing_data::findOrFail($id);

        if (Auth::user()->hasRole('3dhubs_manager')) {
            $available_printers = printers::all()->where('printer_status', '!=', 'Missing')->where('printer_status', '!=', 'On Loan')->where('printer_status', '!=', 'Signed out')->pluck('id', 'id')->all();
        } else {
            $available_printers = printers::all()->where('printer_status', '!=', 'Missing')->where('printer_status', '!=', 'On Loan')->where('printer_status', '!=', 'Signed out')->where('in_use', 0)->pluck('id', 'id')->all();
        }

        return view('printingData.create',compact('available_printers','data'));
    }
}
