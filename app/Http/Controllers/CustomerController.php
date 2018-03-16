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
    public function __construct()
    {

        //$this->middleware('auth')->except('index');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showprints($email)
    {
        $activejobs = Jobs::orderBy('created_at','desc')->where('customer_email', '=', $email)->where(function ($query){$query->where('status','=','Waiting')->orWhere('status','=','Approved')->orWhere('status','=','In Progress');})->get();
        $completedjobs = Jobs::orderBy('created_at','desc')->where('customer_email', '=', $email)->where('status','!=','Waiting')->where('status','!=','Approved')->where('status','!=','In Progress')->get();
        return view('welcome.myprints', compact('email','activejobs','completedjobs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    } 
}
