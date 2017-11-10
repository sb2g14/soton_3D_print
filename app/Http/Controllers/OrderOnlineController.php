<?php

namespace App\Http\Controllers;

use App\Rules\Alphanumeric;
use App\Rules\SotonEmail;
use App\Rules\SotonID;
use App\Rules\SotonIdMinMax;
use Illuminate\Http\Request;
use App\Rules\CustomerNameValidation;
use App\JobsPrints;
use App\printers;
use App\Jobs;
use App\Prints;
use App\cost_code;

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
            'student_name' => [
                'required',
                'string',
                'min:3',
                'max:100',
                new CustomerNameValidation
            ],
            'email' => [
                "required",
                "min:14",
                "max:100",
                "email",
                new SotonEmail
            ],
            'student_id' => [
                'required',
                'digits_between:8,9',
                new SotonID,
            ],
            'use_case' => [
                'required',
                'min:3',
                'max:30',
                new Alphanumeric
            ]
        ]);
        // Store the online request in the database
        $job = new Jobs;

        $job -> total_material_amount = NULL;
        $job -> total_price = NULL;
        $job -> total_duration = NULL;
        $job -> paid = 'No';
        $job -> payment_category = NULL;
        $job -> cost_code = NULL;
        $job -> use_case = $online_request('use_case');
        $job -> customer_id = $online_request('student_id');
        $job -> customer_name = $online_request('student_name');
        $job -> customer_email = $online_request('email');
        $job -> requested_online = 1;

        $job->save();

        // Show flashing message
        session()->flash('message', 'Your job has been submitted. Our manager will contact you 
        shortly via provided email');
        session()->flash('alert-class', 'alert-success');

        // Redirect to home directory
        return redirect()->home();
    }
}
