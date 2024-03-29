<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use App\Printers;
use App\FaultData;
use Illuminate\Http\Request;
use Auth;

class PrintersController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            // Check if all current jobs are finished
            $printers_busy = Printers::where('in_use','=', 1)->get();
            foreach ($printers_busy as $printer_busy) {
                $printer_busy->changePrinterStatus($printers_busy);
            }

            $printers = Printers::all();
            return view('printers.index', compact('printers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $printer_types = Printers::select('printer_type')->groupBy('printer_type')->get();
        return view('printers.create', compact('printer_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
       // dd(request()->all());
        $this -> validate(request(), [
            'id' => 'required|numeric',
            'serial_no' => 'required',
            'printer_type' => 'required',
        ]);
        $printer_type = request('printer_type');
        if ($printer_type=="Other"){
            $printer_type = request('other_printer_type');
        }
        if(request('printer_permission')=="isWorkshop")
        {
            $printer_permission = true;
        }else{
            $printer_permission = false;
        }
        Printers::create([
            'id' => request('id'),
            'serial_no' => request('serial_no'),
            'printer_type' => $printer_type,
            'printer_status'=> 'Available',
            'isWorkshop' => $printer_permission]);

        return redirect('/printers/index');
    }

    /**
     * Display the specified resource. 
     *
     * @param  \App\printers  $printers
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //TODO: this function should show the printer history which is currently in the issues controller!
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\printers  $printers
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $printer = Printers::find($id);
        $printer_types = Printers::select('printer_type')->groupBy('printer_type')->get();
        return view('printers.edit',compact('printer','printer_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\printers  $printers
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $this -> validate(request(), [
            'serial_no' => 'required',
            'printer_type' => 'required',
            'printer_permission' => 'required'
        ]);
        $printer_type = request('printer_type');
        if ($printer_type=="Other"){
            $printer_type = request('other_printer_type');
        }

        $printer = Printers::find($id);
        if(!empty(request('printer_status')))
        {
            $printer_status = request('printer_status');
        }else{
            $printer_status = $printer->printer_status;
        }
        if(request('printer_permission')=="isWorkshop")
        {
            $printer_permission = true;
        }else{
            $printer_permission = false;
        }
        
        $printer->update([
            'serial_no' => request('serial_no'),
            'printer_type' => $printer_type,
            'printer_status'=> $printer_status,
            'isWorkshop' => $printer_permission]);

        return redirect('/printers/index');
    }

    public function updatePrinterStatus()
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\printers  $printers
     * @return \Illuminate\Http\Response
     */
    public function destroy(printers $printers)
    {
        //
    }

}
