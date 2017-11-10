<?php

namespace App\Http\Controllers;

use App\Rules\Alphanumeric;
use App\Rules\SotonEmail;
use App\Rules\SotonID;
use App\Rules\SotonIdMinMax;
use Illuminate\Http\Request;
use App\Rules\CustomerNameValidation;

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
        request()->validate([
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
    }
}
