<?php

namespace App\Http\Controllers;

use App\FaultUpdates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Printers;
use App\FaultData;
use App\posts;
use Auth;

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
        $issues =  FaultData::orderBy('created_at', 'desc')->where('resolved', 0)->get();
        return view('issues.index', compact('issues'));
    }

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
                'users_id_created_issue' => Auth::user()->id,
                'users_name_created_issue' => Auth::user()->name,
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $issues =  FaultData::orderBy('created_at', 'desc')->where('resolved', 1)->where('printers_id', $id)->get();

        return view('issues.show', compact('issues', 'id'));
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
            'users_id' => Auth::user()->id,
            'users_name' => Auth::user()->name,
            'fault_data_id' => $issue_id,
            'printer_status' => Input::get('select'),
            'days_out_of_order'=> floor((time() - strtotime($issue->created_at)) / (60 * 60 * 24)),
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
        //
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
            // If the redirection is from welcome get the post id
            $id = request('id');
            if ( !empty ( $id ) ) {
                $post = posts::findOrFail($id);
                $title = $post->title;
                $body = $post->body;
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
        $issue->update(['users_id_resolved_issue'=>Auth::user()->id,
            'users_name_resolved_issue' => Auth::user()->name,
            'printer_status' => 'Available',
            'days_out_of_order' => floor((time() - strtotime($issue->created_at)) / (60 * 60 * 24)),
            'message_resolved' => request('body'),
            'resolved' => 1]);
        $printer = printers::findOrFail($issue->printers_id);
        $printer->update(['printer_status'=>'Available']);

        session()->flash('message', 'The issue has been resolved!');
        session()->flash('alert-class', 'alert-success');

        return redirect('issues/index');
    }
}
