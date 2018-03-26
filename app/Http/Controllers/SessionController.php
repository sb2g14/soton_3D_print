<?php

namespace App\Http\Controllers;

use App\Rota;
use App\Sessions;
use App\Availability;
use App\staff;
use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use App\StatisticsHelper;
use Carbon\Carbon;

class SessionController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth')->except('index');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating and updating sessions of a day.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($date)
    {
        $sessions = $this->getSessionsForDate($date);
        //approximate start and end time of the next session
        //logic is: if no session so far for this day, then first session is 9am till 12pm
        //          otherwise, assume the enxt session starts after the previous one and is as long as the previous session.
        $latest = $this->getLastSessionForDate($date);
        if($latest){
            $newstarttime = new Carbon($latest->end_date);
            $newendtime = new Carbon($latest->start_date); 
            $newendtime = $newstarttime->copy()->addMinutes($newendtime->copy()->diffInMinutes($newstarttime->copy()));
            $newstarttime = new Carbon($latest->end_date);
        }else{
            $newstarttime = new Carbon($date.' 09:00:00');
            //$newstarttime->hour(9)->minute(0)->second(0);
            $newendtime = new Carbon($date.' 12:00:00'); 
            //$newendtime->hour(12)->minute(0)->second(0);
        }
        // need to convert to a time, so that the date-time-picker is happy
        $newstarttime = $newstarttime->format('H:i');
        $newendtime = $newendtime->format('H:i');
        // Get the events for this date
        $events = Event::orderBy('start_date')->where('start_date','<=',$date)->where('end_date','>=',$date)->get();
        // Finally show the blade...
        return view('rota.newsession', compact('date','sessions','newstarttime','newendtime','events'));
    }
    
    /** process request for new session display -> gets date from input and redirects to the appropriate session add/edit blade**/
    public function startcreate()
    {
        $this -> validate(request(), [
            'newdate' => 'required'
        ]);
        $date = request('newdate');
        return redirect('/rota/session/new/'.$date);
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
         
        session()->flash('message', 'The session has been successfully added to the database!');

        return redirect('/rota/session/new/'.$date);
    }
    
    /** prepare query for sessions for one day **/
    private function querySessionsForDate($date){
        $t1 = new Carbon($date.' 0:00:00');
        $t2 = new Carbon($date.' 23:59:59');
        $sessions = Sessions::where('start_date','>=',$t1)->where('start_date','<=',$t2);
        return $sessions;
    }
    
    /** get all sessions for one day **/
    private function getSessionsForDate($date){
        $sessions = $this->querySessionsForDate($date)->orderBy('start_date')->get();
        return $sessions;
    }

    /** get only the last session of a day **/
    private function getLastSessionForDate($date){
        $sessions = $this->querySessionsForDate($date)->orderBy('start_date','desc')->first();
        return $sessions;
    }
    
    /** returns all the staff, that are available for that session and eligible to be assigned to a session **/
    private function getDemonstratorsForSession($id){
        //TODO: need to order by date of last session asc
        //TODO: need to split into experienced and new demonstrators
        $demonstrators = staff::whereHas('availability', function ($query) use ($id) {
                $query->where('availability', 'available')->where('sessions_id', $id);
                })
                ->where('role','!=', 'Former member')
                ->where('SMT_date','!=', NULL)
                ->orderBy('last_name')
                ->pluck('first_name','id')->all();
        return $demonstrators;
    }
    
    /** shows blade that assigns demonstrators to the rota **/
    public function showassign($date)
    {
        $sessions = $this->getSessionsForDate($date);
        //TODO: need to sort out who is experienced and who hasn't demonstrated for long...
        $demonstrators = array();
        foreach($sessions as $s){
            $id = $s->id;
            $demonstrators['session_'.$id] = $this->getDemonstratorsForSession($id);
        }
        $demonstratorsX = $this->getDemonstratorsForSession($id);
        return view('rota.assign', compact('date','sessions','demonstrators'));
    }

    /** assigns demonstrators to the rota **/
    public function assign($date)
    {
        $sessions = $this->getSessionsForDate($date);
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
        return redirect('/rota/assign/'.$date);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }
    
    
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        //need to get id from submit button...
        $id = (int)request('btn_update');
        echo($id);
        $this -> validate(request(), [
            'date' => 'required',
            'start_time_'.$id => 'required',
            'end_time_'.$id => 'required',
            'num_dem_'.$id => 'required'
        ]);

        //convert time to date
        $date = request('date');
        $start_date = new Carbon($date.' '.request('start_time_'.$id));
        $end_date = new Carbon($date.' '.request('end_time_'.$id));
        
        //TODO: this check is not yet working
        if(request('public_'.$id)=="isPublic")
        {
            $session_public = true;
        }else{
            $session_public = false;
        }
        
        
        $session = Sessions::findOrFail($id);
        $session->update(array('start_date' => $start_date, 
                               'end_date' => $end_date, 
                               'dem_required' => request('num_dem_'.$id), 
                               'public' => $session_public));

        session()->flash('message', 'The session has been successfully updated!');

        return redirect('/rota/session/new/'.$date);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
}
