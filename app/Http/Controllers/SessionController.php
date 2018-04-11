<?php

namespace App\Http\Controllers;

use App\Sessions;
use App\Rota;
use App\Availability;
use App\staff;
use App\Event;
use App\Http\Controllers\Traits\RotaDefaultsTrait;
use App\Http\Controllers\Traits\RotaAvailabilityTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use App\StatisticsHelper;
use Carbon\Carbon;
use Alert;

/**
 * This controller handles sessions when the printing service is open.
 * Sessions need to be created, updated and deleted. They also require assignment of demonstrators to them.
 *
 * A session is the smallest instance of the service work time. It has a start and an end time.
 * A session can be either public, meaning that anyone can attend it,
 * or private, meaning that only invited people should attend it.
 * Each session requires a certain number of demonstrators to run it.
 * All sessions in one day form a rota (See RotaController).
 **/
class SessionController extends Controller
{
    use RotaDefaultsTrait;
    use RotaAvailabilityTrait;
    
    public function __construct()
    {

        $this->middleware('auth')->except('index');

    }

    /** prepare query for sessions for one day **/
    private function querySessionsForDate($date){
        $t1 = new Carbon($date.' 0:00:00');
        $t2 = new Carbon($date.' 23:59:59');
        $sessions = Sessions::where('start_date','>=',$t1)->where('start_date','<=',$t2);
        return $sessions;
    }

    
    

    /** get only the last session of a day **/
    public function getLastSessionForDate($date){
        $sessions = $this->querySessionsForDate($date)->orderBy('start_date','desc')->first();
        return $sessions;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }
    
    /** process request for new session display -> gets date from input and redirects to the appropriate session add/edit blade**/
    public function startcreate()
    {
        $this -> validate(request(), [
            'newdate' => 'required'
        ]);
        $date = request('newdate');
        return redirect('/rota/session/'.$date);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //dd(request()->all());
        $this -> validate(request(), [
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'num_dem' => 'required'
        ]);
        //convert time to date
        $date = request('date');
        $start_date = new Carbon($date.' '.request('start_time'));
        $end_date = new Carbon($date.' '.request('end_time'));

        if(request('session_public')=="isPublic")
        {
            $session_public = true;
        }else{
            $session_public = false;
        }

        $session = new sessions;
        $session -> start_date = $start_date;
        $session -> end_date = $end_date;
        $session -> dem_required = request('num_dem');
        $session->public = $session_public;

        // Submit the data to the database

        $session->save();
         
        // Show notification

        session()->flash('message', 'The session has been successfully added to the database!');
        //notify()->flash('The session has been successfully added to the database!', 'success', [
        //    'text' => 'please add more sessions or update existing sessions for this date.',
        //]);

        return redirect('/rota/session/'.$date);
    }

    
    
    /** shows blade that assigns demonstrators to the rota **/
    public function showassign($date)
    {
        $rota = new Rota($date);
        $sessions = $rota->sessions;
        $temp = $this->getOptions($sessions);
        $demonstrators = $temp[0];
        $lists = $temp[1];
        $default = $this->choosedefault($sessions, $lists);
        return view('rota.assign', compact('date','sessions','demonstrators','default','rota'));
    }

    /** assigns demonstrators to the rota **/
    public function assign($date)
    {
        $rota = new Rota($date);
        $sessions = $rota->sessions;
        foreach($sessions as $s){
            for($d=0;$d<$s->dem_required;$d++){
                $this -> validate(request(), [
                    'dem_'.$s->id.'_'.$d => 'required',
                ]);
            }
            // Remove old Assignments
            $session = Sessions::findOrFail($s->id);
            $session->staff()->detach();
            $session->save();
            // Do new Assignments
            for($d=0;$d<$session->dem_required;$d++){
                $staff = staff::findOrFail(request('dem_'.$session->id.'_'.$d));
                $session->staff()->attach($staff);
                $session->save();
            }
        }
        
        // Show notification
        session()->flash('message', 'Demonstrators have been assigned!');
        /*notify()->flash('Demonstrators have been assigned!', 'success', [
            'text' => 'The rota for '.$date.' has been completed. Please review your changes before sending the rota to the demonstrators.',
        ]);*/
        return redirect('/rota/assign/'.$date);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {
        // Need to get id from submit button...
        $id = (int)request('btn_update');
        // Check all fields have been filled
        $this -> validate(request(), [
            'date' => 'required',
            'start_time_'.$id => 'required',
            'end_time_'.$id => 'required',
            'num_dem_'.$id => 'required'
        ]);
        // Convert time to date
        $date = request('date');
        $start_date = new Carbon($date.' '.request('start_time_'.$id));
        $end_date = new Carbon($date.' '.request('end_time_'.$id));
        
        // Set isPublic according to user selection
        if(null !== request('public_'.$id))
        {
            $session_public = true;
        }else{
            $session_public = false;
        }
        
        // Perform update in database
        $session = Sessions::findOrFail($id);
        $session->update(array('start_date' => $start_date, 
                               'end_date' => $end_date, 
                               'dem_required' => request('num_dem_'.$id), 
                               'public' => $session_public));
        
        // Give user feedback
        session()->flash('message', 'The session has been successfully updated!');

        return redirect('/rota/session/'.$date);
    }

    /**
     * Remove the specified session from storage.
     */
    public function destroy($id)
    {
        $session = Sessions::findOrFail($id);
        // save edited date for redirect
        $date = new Carbon($session->start_date);
        $date = $date->toDateString();
        // delete related data and then the actual session
        $session->availability()->delete();
        $session->delete();
        // redirect
        return redirect('/rota/session/'.$date);
    }
}
