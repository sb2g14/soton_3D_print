<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\staff;
use App\ChartsHelper;
use App\Http\Controllers\RotaController;

class AboutWorkshopController extends Controller
{
    // This is controller to manage AboutWorkshop page
    /**
     * Display a listing of the resource.
     *
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
