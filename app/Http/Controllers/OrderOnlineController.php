<?php

namespace App\Http\Controllers;

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
                new CustomerNameValidation
            ]
        ]);
    }
}
