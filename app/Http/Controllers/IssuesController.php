<?php

namespace App\Http\Controllers;

use App\FaultUpdates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Printers;
use App\FaultData;
use App\posts;
use Auth;
use Excel;
use Carbon\Carbon;
use Charts;
class IssuesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {

        $this->middleware('auth');

    }
    public function index()
    {
        $issues =  FaultData::orderBy('id', 'desc')->where('resolved', 0)->get();

        return view('issues.index', compact('issues','excel'));
    }
//    public function printersIssuesExport()
//    {
//
//        // Get all issues
//
//        $issues = FaultData::select('printers_id','serial_number','created_at','users_name_created_issue','printer_status','body','updated_at','users_name_resolved_issue','message_resolved','days_out_of_order')->get();
//
//        // Initialize the array which will be passed into the Excel
//        // generator.
//        $issuesArray = [];
//
//        // Define the Excel spreadsheet headers
//        $issuesArray[] = ['Printer ID', 'Printer SN','Date','Demonstrator Sign','Printer Status','Issue','Repair Date','Repair Demonstrator Sign','Comment','Days Out of Order'];
//
//        // Convert each member of the returned collection into an array,
//        // and append it to the payments array.
//        foreach ($issues as $issue) {
//            if(empty($issue->users_name_resolved_issue)){
//                $issue->updated_at = null;
//            }
//            $issuesArray[] = $issue->toArray();
//        }
//
//        // Generate and return the spreadsheet
//        Excel::create('FaultData', function($excel) use ($issuesArray) {
//
//            // Set the spreadsheet title, creator, and description
//            $excel->setTitle('3D_printers_issues');
//            $excel->setCreator(Auth::user()->name)->setCompany('3D printing workshop');
//            $excel->setDescription('Excel file used as a backup for information about 3D printers faults in the 3D printing workshop at University of Southampton');
//
//            // Build the spreadsheet, passing in the payments array
//            $excel->sheet('sheet1', function($sheet) use ($issuesArray) {
//                $sheet->fromArray($issuesArray, null, 'A1', false, false);
//            });
//
//        })->download('xlsx');
//    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this -> validate(request(), [
            'title' => 'required',
            'body' => 'required',
        ]);
        $id = request('id');
            // Create new issue and update printer status
            $printer = Printers::findOrFail($id);
            $printer->update(['printer_status' => Input::get('select')]);
            FaultData::create([
                'printers_id' => $id,
                'serial_number' => $printer->serial_no,
                'staff_id_created_issue' => Auth::user()->staff->id,
                'printer_status' => Input::get('select'),
                'title' => request('title'),
                'body' => request('body')
            ]);

            session()->flash('message', 'The new issue created!');
            session()->flash('alert-class', 'alert-success');

            return redirect('issues/index');
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

    private function createPrinterHistoryEntry($lastEntry,$entryCounter){
        //print last entry
        $history_entry = array();
        $history_entry['EntryID'] = $lastEntry->EntryID;
        $history_entry['StartDate'] = new \Carbon\Carbon($lastEntry->StartDate);
        if(!$lastEntry->EndDate){
            $history_entry['EndDate'] = null;
        } else {
            $history_entry['EndDate'] = new \Carbon\Carbon($lastEntry->EndDate);
        }
        $history_entry['Description'] = $lastEntry->Description;
        $history_entry['Type'] = $lastEntry->Type;
        $history_entry['Class'] = '';
        if($lastEntry->Type == 'Use'){
            $history_entry['Type'] = $entryCounter.' Prints';
            if($lastEntry->Description === 'Success'){
                $history_entry['Class'] = 'alert alert-psuccess';
            }else{
                $history_entry['Class'] = 'alert alert-pfailed';
            }
        }
        if($lastEntry->Type === 'Loan'){
            $history_entry['Class'] = 'alert alert-onloan';
        }
        if($lastEntry->Type === 'Broken'){
            $history_entry['Class'] = 'alert alert-broken';
        }
        if($lastEntry->Type === 'Missing'){
            $history_entry['Class'] = 'alert alert-missing';
        }
        return $history_entry;
    }

    private function getPrinterHistory($id){
        $outEntries = [];
        $printer = Printers::where('id', $id)->first();
        //collect all prints and loans
        $printdata = $printer->prints()->select('created_at AS StartDate', 'updated_at AS EndDate','purpose AS Type','status AS Description', 'id as EntryID');
        //collect all issues
        $issuedata = $printer->fault_data()->select('created_at AS StartDate', 'resolved_at AS EndDate', 'printer_status AS Type', 'body AS Description', 'id as EntryID');
        //combine them
        $historydata = $printdata->unionAll($issuedata);
        //collect all issue updates
        $issueupdatedata = $printer->fault_data()->orderBy('created_at','desc')->where('resolved',0)->first();
        if($issueupdatedata){
            $issueupdatedata = $issueupdatedata->FaultUpdates()->select('created_at AS StartDate', 'updated_at AS EndDate', 'printer_status AS Type', 'body AS Description', 'fault_data_id as EntryID');
            //combine since there are issues
            $historydata = $historydata->unionAll($issueupdatedata);
        }
        //sort entries
        $historydata = $historydata->orderBy('StartDate', 'DESC')->get();
        $lastEntry = null;
        $entryCounter = 1;
    
        foreach($historydata as $entry){
            if($lastEntry){
                if($entry->Type === 'Use' && $entry->Type === $lastEntry->Type && $entry->Description === $lastEntry->Description){
                    $entryCounter += 1;
                    //combine them
                    $lastEntry->StartDate = $entry->StartDate;
                }else{
                    //print last entry
                    $out = $this->createPrinterHistoryEntry($lastEntry,$entryCounter);
                    $outEntries[] = $out;
                    $entryCounter = 1;
                    //$this->renderHistoryEntryToHTML($out);
                    $lastEntry = $entry;
                }
            }else{
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $issue = FaultData::findOrFail($id);
        return view('issues.update', compact('issue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $this -> validate(request(), [
            'body' => 'required',
        ]);

        // Find issue to update
        $issue_id = request('id');
        $issue = FaultData::findOrFail($issue_id);

        // Update issue and update printer status
        $printer = Printers::findOrFail($issue->printers_id);
        $printer->update(['printer_status' => Input::get('select')]);
        FaultUpdates::create([
            'staff_id' => Auth::user()->staff->id,
            'users_name' => Auth::user()->staff->first_name.' '.Auth::user()->staff->last_name,
            'fault_data_id' => $issue_id,
            'printer_status' => Input::get('select'),
            'body' => request('body')
        ]);


        session()->flash('message', 'The issue has been updated!');
        session()->flash('alert-class', 'alert-success');

        return redirect('issues/index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $issue = FaultData::findOrFail($id);

        Printers::where('id', $issue->printers_id)->update(array('printer_status' => 'Available'));

        $issue->delete();

        notify()->flash('The issue has been deleted from the database.', 'success', [
            'text' => "Please proceed further for creating another one.",
        ]);

        return redirect('/issues/index');
    }
    public function deleteupdate($id)
    {
        $update = FaultUpdates::findOrFail($id);
        $issue = $update->FaultData;
        $update->delete();
        if(!empty(array_filter((array)$issue->FaultUpdates))) {
            $previous_status = $issue->FaultUpdates()->orderBy('created_at', 'desc')->first()->printer_status;
        }else{
            $previous_status = $issue->printer_status;
        }

        Printers::where('id','=', $issue->printers_id)->update(array('printer_status' => $previous_status));
        notify()->flash('The issue update has been deleted from the database.', 'success', [
            'text' => "The printer status is changed to the previous one.",
        ]);

        return redirect('/issues/index');
    }

    public function select()
    {
        $printers =  printers::pluck('id','id')->all();

        return view('issues.select', compact('printers'));
    }
    public function selectPrinter()
    {
        // Get the id of selected printer from the dropdown
        $getSelectPrinter = Input::get('select');
        $selectedPrinter = Printers::findOrFail($getSelectPrinter);

        $printer_issues_id= FaultData::where('resolved', 0)->pluck('printers_id');
        $printer_issues_id = $printer_issues_id->toArray();

        if( in_array($getSelectPrinter, $printer_issues_id)) {
            // If selected printer has unresolved issue redirect to issues view

            session()->flash('message', 'There is unresolved issue with the selected printer. Please resolve or update the existing issue');
            session()->flash('alert-class', 'alert-danger');

            return redirect('issues/index');
        } else {
            // If the redirection is from welcome get from the post
            if ( !empty ( $title ) ) {
                $title = request('title');
                $body = request('body');
            } else {
                $title = '';
                $body = '';
            }
            return view('issues.create', compact('selectedPrinter', 'title', 'body'));
        }
    }
    public function  showResolve($id)
    {
        $issue = FaultData::findOrFail($id);
        return view('issues.resolve', compact('issue'));
    }
    public function resolve()
    {
        $this -> validate(request(), [
            'body' => 'required',
        ]);

        $id = request('id');
        $issue = FaultData::findOrFail($id);
        $issue->update(['staff_id_resolved_issue'=>Auth::user()->staff->id,
            'resolved_at'=> Carbon::now('Europe/London'),
            //'printer_status' => 'Available',
            'message_resolved' => request('body'),
            'resolved' => 1]);
        $printer = printers::findOrFail($issue->printers_id);
        $printer->update(['printer_status'=>'Available']);


        session()->flash('message', 'The issue has been resolved!');
        session()->flash('alert-class', 'alert-success');

        return redirect('issues/index');
    }
}
