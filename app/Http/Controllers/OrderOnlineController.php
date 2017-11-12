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


class OrderOnlineController extends Controller
{
    public function index()
    {
        return view('orderOnline');
    }

    public function create()
    {
        return view('OnlineJobs.create');
    }

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
            $cost_code = $query->value('cost_code');
        } else {
            // Otherwise, accept a given cost code
            $cost_code = $online_request['use_case'];
        }

        // Updating database
        $job -> update(array(
            'paid'=> 'No',
            'payment_category' => $payment_category,
            'use_case' => strtoupper($online_request['use_case']),
            'cost_code' => $cost_code,
            'requested_online' => 1,
            'status' => 'Waiting',
            ));

        // Send an email to the online jobs manager
        $users = User::role('OnlineJobsManager')->get();
        foreach($users as $user){
            \Mail::to($user)->send(new onlineRequest($user,$job));
        }
//        $user = User::first();
//        \Mail::to($user)->send(new onlineRequest($user,$job));

        // Notification of request acceptance
        notify()->flash('Your order request has been accepted!', 'success', [
            'text' => 'Please wait for our manager to contact you via provided email address',
        ]);
        // Redirect to home directory
        return redirect()->home();
    }
}
