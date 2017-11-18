<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhotolibraryController extends Controller
{
    public function index()
    {
        return view('photolibrary');
    }
}
