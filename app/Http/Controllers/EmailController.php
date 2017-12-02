<?php

namespace App\Http\Controllers;

use App\Mail\jobReject;
use Illuminate\Http\Request;
use App\Jobs;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    // This function sends an email about a rejected online job
    public function sendReject($id)
    {
        $job = Jobs::findOrFail($id);
        $title = 'The online job by ' . $job->customer_name . 'has been rejected';
        $content = 'Dear ' . $job->customer_name . ', I am writing to notify that your online job request to the 3D printing 
        workshop has been rejected';
        Mail::to($job->customer_email)->queue(new jobReject());
    }
}
