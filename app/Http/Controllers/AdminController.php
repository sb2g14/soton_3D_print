<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use Illuminate\Http\Request;


/** The functions for managing permissions, roles, etc. **/
class AdminController extends Controller
{
   
    
   
    
    
    //// GENERIC PUBLIC FUNCTIONS ////
    //---------------------------------------------------------------------------------------------------------------//
    
    /** Specify pages available to an unauthenticated user **/
    public function __construct()
    {

        $this->middleware('auth');

    }

    
    //// CONTROLLER BLADES ////
    //---------------------------------------------------------------------------------------------------------------//

    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     **/
    public function index()
    {
        return view('home');
    }
}
