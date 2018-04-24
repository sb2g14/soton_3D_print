<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\staff;
use App\ChartsHelper;
use App\Http\Controllers\RotaController;

class AboutWorkshopController extends Controller
{
    
    //// CONTROLLER BLADES ////
    //---------------------------------------------------------------------------------------------------------------//
    
    /**
     *
     * @blade_address /aboutWorkshop
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rc = new RotaController();
        // Find all the records in the staff database with role 'Coordinator'
        $coordinators = staff::where('role','=', 'Coordinator')->get();
        // Find all the records in the staff database with role 'Lead Demonstrator'
        $lead_demonstrators = staff::where('role','=', 'Lead Demonstrator')->get();
        //get workshop usage chart
        $stats = new ChartsHelper();
        $chart = $stats->createChartWorkshopUsage('prussian-uni');
        //get opening hours
        $open = $rc->openingHours();
        return view('aboutWorkshop.index',compact('coordinators','lead_demonstrators','chart','open'));
    }
}
