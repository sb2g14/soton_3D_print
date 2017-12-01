<?php

namespace App\Http\Controllers;

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
use App\Mail\jobConfirmation;
use App\staff;
use Carbon\Carbon;
use Auth;


class OrderOnlineController extends Controller
{
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

        // Add additional information

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
        //$email = '3DPrintFEE@soton.ac.uk';
        //$user = User::where('email','=','3DPrintFEE@soton.ac.uk')->first();
        $user = User::find(2);
        \Mail::to($user)->send(new onlineRequest($user,$job));

        // Notification of request acceptance
        notify()->flash('Your order request has been accepted!', 'success', [
            'text' => 'Please wait for our manager to contact you via provided email address',
        ]);
        // Redirect to home directory
        return redirect()->home();
    }

    // Online job manager sees all the online job requests:
    public function index()
    {
        $jobs = Jobs::orderBy('created_at', 'desc')->where('status','Waiting')->where('requested_online', 1)->get();
        return view('OnlineJobs.index', compact('jobs'));
    }

    // Online job manager reviews each online job request and fills in all the required information.
    public function checkrequest($id)
    {
        $job = Jobs::findOrFail($id); // Find the job in DB by {$id}
        return view('OnlineJobs.checkrequest', compact('job'));
    }

    // The prints are being assigned to each job and the cost calculated and sent to a requester for approval
    public function assignPrints($id)
    {
        // Validate and store the printing time and material amount specified to each print of a current {$id} job
        $assigned_print = request()->validate([
            'hours' => 'required',
            'minutes' => 'required',
            'material_amount' => 'required|numeric|min:0.1|max:9999',
            'comments' => 'max:255'
            ]);

        // create a print from the specified details
        $time = $assigned_print["hours"].':'.sprintf('%02d', $assigned_print["minutes"]); // Created printing time
        // Create price
        $price = round(3 * ($assigned_print["hours"] + $assigned_print["minutes"] / 60) +
            5 * $assigned_print["material_amount"] / 100, 2);
        // Create a print
        $print = new Prints;
        $print -> time = $time;
        $print -> price = $price;
        $print -> save();

        // Update a print with the details entered by customer
        $print -> update(array(
            'purpose' => 'Use',
            'material_amount' => $assigned_print["material_amount"],
            'print_comment' => $assigned_print["comments"],
            'status' => 'waiting'
        ));

        $job = Jobs::findOrFail($id); // Find the job in DB by {$id}

        // Associate this print with the current job
        $job->prints()->attach($print);

        // Notify that the print was created
        notify()->flash('The print has been assigned to this job!', 'success', [
            'text' => 'You can either add more prints or accept this job and notify customer',
        ]);

        return redirect("/OnlineJobs/checkrequest/{$job->id}");
    }
    public function approved()
    {
        $approved_jobs = Jobs::orderBy('created_at', 'desc')->where('status','Approved')->where('requested_online', 1)->get();

        return view('OnlineJobs.approved', compact('approved_jobs'));
    }

    // The job is accepted and the customer is informed about the price.
    public function approveRequest($id)
    {
        $job = Jobs::findOrFail($id);

        $total_minutes = 0;
        foreach ($job->prints as $print){
            list($h, $i, $s) = explode(':', $print->time);
            $minutes = $h*60 + $i;
            $total_minutes = $total_minutes + $minutes;
        }
        $total_time = round($total_minutes/60).':'.sprintf('%02d', $total_minutes%60);

        $job->update(array(
            'status' => 'Approved',
            'approved_at' => Carbon::now('Europe/London'),
            'job_approved_by' => Auth::user()->staff->id,
            'total_duration' => $total_time,
            'total_material_amount' => $job->prints->sum('material_amount'),
            'total_price' => $job->prints->sum('price'),
            )
        );

//        // Send an email to the customer with the total job parameters and require acceptance
//        $email = $job->customer_email;
//
//        \Mail::send('emails.jobConfirmation', [], function($message) use ($email)
//        {
//            $message->to($email)->subject('This is test e-mail');
//        });
//        var_dump( \Mail:: failures());

        // Notify the manager about successfully accepted job
        notify()->flash('The job has been approved', 'success', [
            'text' => 'Please send an email notification to the customer with the job quote',
        ]);
        return redirect('OnlineJobs/approved');
    }

    // The job has been rejected by Online Jobs Manager
    public function rejectJobManager($id)
    {
        $job = Jobs::findOrFail($id);
        $prints = $job->prints;
        foreach($prints as $print) {
            $job->prints()->detach($print->id);
            $print->delete();
        }
        $job->delete();

        // Notify that the job was rejected
        notify()->flash('The job has been rejected', 'success', [
            'text' => 'Please explain why the job has been rejected via email',
        ]);

        return redirect('OnlineJobs/index');
    }
}
