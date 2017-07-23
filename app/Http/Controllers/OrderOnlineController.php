<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderOnlineController extends Controller
{
    public function index()
    {
        return view('orderOnline');
    }
}
