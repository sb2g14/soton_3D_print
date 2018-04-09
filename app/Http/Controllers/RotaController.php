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
use Carbon\Carbon;
use App\Http\Controllers\SessionController;

/**
 * This controller handles rotas.
 * A rota is the collection of sessions for a day.
 *
 * This controller has functions to display a group of sessions, and to merge sessions into rotas and open-hours.
 **/
class RotaController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth')->except('index');

    }
    
    /** gets the upcoming sessions from the database**/
    private function getUpcomingSessions(){
        $t1 = new Carbon();
        $t1 = $t1->subWeeks(2);
        $sessions = Sessions::with('staff')->orderBy('start_date')->where('start_date','>=',$t1)->get(); 
        return $sessions;   
    }
    
    /** gets the upcoming events from the database**/
    private function getUpcomingEvents(){
        $t1 = new Carbon();
        $t1 = $t1->subWeeks(2);
        $events = Event::orderBy('start_date')->where('end_date','>=',$t1)->get(); 
        return $events;   
    }
    
    /** merges the upcoming events and rotas and sorts them by date **/
    private function mergeItems($rotas,$events){
        $items = [];
        foreach($rotas as $r){
            $start = $r['start_date'];
            $items[$start.'r'] = $r;
        }
        foreach($events as $e){
            $start = $e->start_date;
            $items[$start.'e'] = $e;
        }
        ksort($items); 
        return $items;
    }

    /** initiate a new rota from an array of sessions **/
    private function initRota($sessions){
        $rota = [];
        // Add the actual sessions
        $rota['sessions'] = $sessions;
        // Add metadata
        $rota['date'] = $sessions[0]->date();
        $rota['start_date'] = $sessions[0]->start_date;
        //$rota['end_date'] = $sessions[-1]->end_date;
        // Group Common Events as Rota Events
        /*$events = $sessions[0]->events()->toArray();
        foreach($sessions as $s){
            $events = array_intersect($events, $s->events()->toArray());
        }
        $rota['events'] = $events;*/
        return $rota;
    }

    /** groups sessions into rotas **/
    public function getRotas($sessions){
        $rotas = [];
        $rsessions = [];
        $lastdate = "";
        foreach($sessions as $s){
            if($s->date() !== $lastdate){
                //new rota started
                if($rsessions != []){
                    //append old rota
                    $rotas[] = $this->initRota($rsessions);
                }
                //reset variables
                $rsessions = [];
                $lastdate = $s->date();
            }
            //append session to rota
            $rsessions[] = $s;
        }
        //append last rota
        if($rsessions != []){
            //append old rota
            $rotas[] = $this->initRota($rsessions);
        }
        return $rotas;
    }
    
    /** gets closure periods from database and converts them into a string that can be interpreted by the date-time-picker **/
    private function getClosureAsString(){
        // get all closure events
        $closures = Event::where('type','closure')->get();
        $closuredates = [];
        foreach($closures as $c){
            //go from start to end date
            //TODO: find smarter way to pass multiple adjacent dates to date-time-picker
            for($d = new Carbon($c->start_date); $d <= new Carbon($c->end_date); $d->addDay()){
                $d = $d->startOfDay();
                $closuredates[] = '"'.$d->toDateTimeString().'"';
            }
        }
        //convert to string that we can insert into JavaScript
        $closures = implode(", ",$closuredates);    
        return $closures;
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Auth::check()) {
            abort(404);
        }
        // Get sessions
        $sessions = $this->getUpcomingSessions();
        // Merge sessions into rota groups
        $rotas = $this->getRotas($sessions);
        // Get upcoming events
        $events = $this->getUpcomingEvents();
        // Merge rotas and events
        $items = $this->mergeItems($rotas,$events);
        
        // Get Closure period and mark as disabled dates
        $closures = $this->getClosureAsString();
        
        // Get current user (for highlight in rotas)
        $user = Auth::user()->staff;
        
        return view('rota.index', compact('sessions','user','items','closures'));
    }

    /**
     * Show the form for creating and updating sessions of a day.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($date)
    {
        if(!Auth::check()) {
            abort(404);
        }
        
        $sc = new SessionController();
        $sessions = $sc->getSessionsForDate($date);
        //approximate start and end time of the next session
        //logic is: if no session so far for this day, then first session is 9am till 12pm
        //          otherwise, assume the enxt session starts after the previous one and is as long as the previous session.
        $latest = $sc->getLastSessionForDate($date);
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

     /**
     * Show the form for creating and updating sessions of a day.
     *
     * @return \Illuminate\Http\Response
     */
    public function createmail($date)
    {
        // Get the sessions for this date
        $sc = new SessionController();
        $sessions = $sc->getSessionsForDate($date);
        // Finally show the blade...
        return view('rota.mail', compact('date','sessions'));
    }

    /**
     * Get a list of dates and times, when the workshop is open
     *
     * @return \Illuminate\Http\Response
     */
    public function openingHours()
    {
        // Get future sessions
        $sessions = $this->getUpcomingSessions();
        // Remove private sessions
        $sessions = $sessions->reject(function ($s) {
            return $s->public == false;
        });
        // Combine sessions into opening hours
        $open = [];
        $lastendtime = null;
        $lastdate = null;
        foreach($sessions as $s){
            if($lastendtime != $s->start_date){
                //unconnected session
                $lastdate = $s->date();
                $lastendtime = $s->end_date;
                $open[$lastdate][] = [$s->start_date,$lastendtime];
            }else{
                //connected to last session
                $lastendtime = $s->end_date;
                $open[$lastdate][sizeof($open[$lastdate]) - 1] = [$open[$lastdate][sizeof($open[$lastdate]) - 1][0],$lastendtime];
            }
        }
        return $open;
    }
}
