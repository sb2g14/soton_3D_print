<?php

namespace App\Http\Controllers;


use Auth;
use App\Printers;
use App\FaultData;
use Carbon\Carbon;
use Charts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

/** controller to manage printers **/
class PrintersController extends Controller
{
    //// PRIVATE (HELPER) FUNCTIONS ////
    //---------------------------------------------------------------------------------------------------------------/

    /** takes the data colelcetd in $lastEntry and formats it so that it can easily be used in the blade 
     * $entryCounter counts how many entries have been grouped for this entry
     **/
    private function createPrinterHistoryEntry($lastEntry,$entryCounter){
        //collect entry
        $history_entry = array();
        $history_entry['EntryID']       = $lastEntry->EntryID;
        $history_entry['StartDate']     = new \Carbon\Carbon($lastEntry->StartDate);
        if(!$lastEntry->EndDate){
            $history_entry['EndDate']   = null;
        } else {
            $history_entry['EndDate']   = new \Carbon\Carbon($lastEntry->EndDate);
        }
        $history_entry['Description']   = $lastEntry->Description;
        $history_entry['Type']          = $lastEntry->Type;
        $history_entry['Class']         = '';
        if($lastEntry->Type == 'Use'){
            $history_entry['Type']      = $entryCounter.' Prints';
            if($lastEntry->Description === 'Success'){
                $history_entry['Class'] = 'alert alert-psuccess';
            }else{
                $history_entry['Class'] = 'alert alert-pfailed';
            }
        }
        if($lastEntry->Type === 'Loan'){
            $history_entry['Class']     = 'alert alert-onloan';
        }
        if($lastEntry->Type === 'Broken'){
            $history_entry['Class']     = 'alert alert-broken';
        }
        if($lastEntry->Type === 'Missing'){
            $history_entry['Class']     = 'alert alert-missing';
        }
        return $history_entry;
    }

    private function getPrinterHistory($id){
        $outEntries = [];
        $printer = Printers::where('id', $id)->first();
        // Collect all prints and loans
        $printdata = $printer->prints()
                             ->select('created_at       AS StartDate', 
                                      'finished_at      AS EndDate',
                                      'purpose          AS Type',
                                      'status           AS Description', 
                                      'id               AS EntryID');
        // Collect all issues
        $issuedata = $printer->fault_data()
                             ->select('created_at       AS StartDate', 
                                      'resolved_at      AS EndDate', 
                                      'printer_status   AS Type', 
                                      'body             AS Description', 
                                      'id               AS EntryID');
        // Combine them
        $historydata = $printdata->unionAll($issuedata);
        
        // Collect all issue updates
        $issueupdatedata = $printer->fault_data()->orderBy('created_at','desc')->where('resolved',0)->first();
        if($issueupdatedata){
            $issueupdatedata = $issueupdatedata->FaultUpdates()
                             ->select('created_at       AS StartDate', 
                                      'updated_at       AS EndDate', 
                                      'printer_status   AS Type', 
                                      'body             AS Description', 
                                      'fault_data_id    AS EntryID');
            // Combine Issue Updates with the rest
            $historydata = $historydata->unionAll($issueupdatedata);
        }
        // Sort all entries (Prints, Issues, Issue Updates) by date
        $historydata = $historydata->orderBy('StartDate', 'DESC')->get();
        
        // Run for loop to process all entries for easy display in theblade later.
        // This loop also groups adjacent Prints with the same outcome
        $lastEntry = null;
        $entryCounter = 1;
        foreach($historydata as $entry){
            if($lastEntry){ //all but first iteration
                if($entry->Type === 'Use' && $entry->Type === $lastEntry->Type && $entry->Description === $lastEntry->Description){
                    //previous entry was also a print with the same outcome
                    $entryCounter += 1;
                    //combine this entry with the previous one
                    $lastEntry->StartDate = $entry->StartDate;
                }else{
                    //this entry can't be combined with the previous one, so we can prepare the previous one for output
                    $out = $this->createPrinterHistoryEntry($lastEntry,$entryCounter);
                    $outEntries[] = $out;
                    //reset
                    $entryCounter = 1;
                    $lastEntry = $entry;
                }
            }else{ //in first iteration
                $lastEntry = $entry;
            }
        }

        if($lastEntry){
            //print very last entry
            $out = $this->createPrinterHistoryEntry($lastEntry,$entryCounter);
            $outEntries[] = $out;
            //$this->renderHistoryEntryToHTML($out);
        }
        return $outEntries;
    }
    
    //// GENERIC PUBLIC FUNCTIONS ////
    //---------------------------------------------------------------------------------------------------------------//
    
    public function __construct()
    {

        $this->middleware('auth');

    }

    //// CONTROLLER BLADES ////
    //---------------------------------------------------------------------------------------------------------------//
    
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
     * Display the printer history 
     *
     * @param  int  $id printer id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $issues = FaultData::orderBy('id', 'desc')->where('printers_id', $id)->get();
        $printer = Printers::where('id', $id)->first();
        $success = round($printer->calculateTotalTimeSuccess() / (24 * 60));
        $loan = round($printer->calculateTotalTimeOnLoan() / (24 * 60));
        $broken = round($printer->calculateTotalTimeBroken() / (24 * 60));
        if ($printer->printer_status === 'Signed out') {
            $total_time = $printer->updated_at->diffInMinutes($printer->created_at);
        } else {
            $total_time = Carbon::now('Europe/London')->diffInMinutes($printer->created_at);
        }
        $idle = round(($total_time - $printer->calculateTotalTimeBroken())/(24*60));
        $chart = Charts::create('pie', 'highcharts')
            ->title('Printer usage')
            ->labels(['Days Printing', 'Days on Loan', 'Days Broken or Missing', 'Days Idle'])
            ->values([$success,$loan,$broken,$idle])
            ->colors(['#1E8765', '#56b893', '#E73238', '#9FB1BD'])
            ->dimensions(400,200)
            ->responsive(true);

        $historyEntries = $this->getPrinterHistory($id);

        return view('issues.show', compact('issues', 'id','printer','chart','historyEntries'));
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
    
    //// CONTROLLER ACTIONS ////
    //---------------------------------------------------------------------------------------------------------------//

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
