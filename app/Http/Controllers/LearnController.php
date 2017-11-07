<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\staff;

class LearnController extends Controller
{
    public function index()
    {
        $coordinators = staff::where('role','=', 'Coordinator')->get();
        return view('learn',compact('coordinators'));
    }
}
