<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RolesManageController extends Controller
{
    public function index()
    {
        return redirect('/admin/home');
    }
}
