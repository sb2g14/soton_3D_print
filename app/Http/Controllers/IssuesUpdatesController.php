<?php

namespace App\Http\Controllers;


use Auth;
use App\FaultData;
use App\FaultUpdates;
use App\Printers;

use Illuminate\Support\Facades\Input;

class IssuesUpdatesController extends Controller
{
    /**
     * Update the specified printer issue in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create()
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


        notify()->flash('The issue has been updated.', 'success');

        return redirect('/issues');
    }


    /** delete issue update
     **/
    public function destroy($id)
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

        return redirect('/issues');
    }
}
