<?php

namespace App\Http\Controllers;

use App\staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use App\Jobs;
use App\StatisticsHelper;

class CustomerController extends Controller
{
    //// CONTROLLER BLADES ////
    //---------------------------------------------------------------------------------------------------------------//
    
    /**
     * Show blade with all the jobs for the authenticated person
     *
     * @return \Illuminate\Http\Response
     */
    public function showprints()
    {
        $name = Auth::user()->name();
        $emails = Auth::user()->emails();
        $activejobs = Jobs::orderBy('created_at','desc')
            ->where(function ($query) use ($emails,$name) {
                    $query->whereIn('customer_email', $emails)
                          ->orWhere('customer_name', $name);})
            ->where(function ($query){
                    $query->where('status','=','Waiting')
                          ->orWhere('status','=','Approved')
                          ->orWhere('status','=','In Progress');})
            ->get();
        $completedjobs = Jobs::orderBy('created_at','desc')
            ->where(function ($query) use ($emails,$name) {
                    $query->whereIn('customer_email', $emails)
                          ->orWhere('customer_name', $name);})
            ->where('status','!=','Waiting')
            ->where('status','!=','Approved')
            ->where('status','!=','In Progress')
            ->get();
        return view('welcome.myprints', compact('name','activejobs','completedjobs'));
    }
}
