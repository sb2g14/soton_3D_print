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
use App\JobsPrints;
use App\printers;
use App\Jobs;
use App\Prints;
use App\cost_code;
use App\Mail\onlineRequest;
use App\staff;


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

    // Online job manager reviews each online job request and fills in all the required information. The requester
    // gets notified about the review of the job.
    public function checkrequest($id)
    {
        $job = Jobs::findOrFail($id);
        return view('OnlineJobs.checkrequest', compact('job'));
    }
}
