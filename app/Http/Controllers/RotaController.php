<?php

namespace App\Http\Controllers;

use Auth;
use App\Rota;
use App\Rotas;
use App\staff;
use App\Sessions;
use App\Availability;
use App\Event;
use App\Http\Controllers\SessionController;
use App\Mail\RotaMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;


/**
 * This controller handles rotas.
 * A rota is the collection of sessions for a day.
 *
 * This controller has functions to display a group of sessions, and to merge sessions into rotas and open-hours.
 **/
class RotaController extends Controller
{

    //// PRIVATE (HELPER) FUNCTIONS ////
    //---------------------------------------------------------------------------------------------------------------//
    
    /** gets the upcoming sessions from the database**/
    private function getUpcomingSessions(){
        $t1 = new Carbon();
        $t1 = $t1->subWeeks(2)->hour(0)->minute(0)->second(0);
        $sessions = Sessions::with('staff')->orderBy('start_date')->where('start_date','>=',$t1)->get(); 
        return $sessions;   
    }
    
    /** gets the upcoming events from the database**/
    private function getUpcomingEvents(){
        $t1 = new Carbon();
        $t1 = $t1->subWeeks(2)->hour(0)->minute(0)->second(0);
        $events = Event::orderBy('start_date')->where('end_date','>=',$t1)->get(); 
        return $events;   
    }
    
    /** merges the upcoming events and rotas and sorts them by date **/
    private function mergeItems($rotas,$events){
        $items = [];
        foreach($rotas as $r){
            $start = $r->start_date;
            $items[$start.'r'] = $r;
        }
        foreach($events as $e){
            $start = $e->start_date;
            $items[$start.'e'] = $e;
        }
        ksort($items); 
        return $items;
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

    //// GENERIC PUBLIC FUNCTIONS ////
    //---------------------------------------------------------------------------------------------------------------//
      
    public function __construct()
    {

        $this->middleware('auth')->except('openingHours');

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
                    //append previous rota
                    $rotas[] = new Rota($lastdate);
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
            //append previous rota
            $rotas[] = new Rota($lastdate);
        }
        return $rotas;
    }
    
    /**
     * Get a list of dates and times, when the workshop is open
     *
     * @return \Illuminate\Http\Response
     */
    public function openingHours()
    {
        // Get future sessions
        $sessions = Rotas::getFutureSessions();
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
    
    
    //// CONTROLLER BLADES ////
    //---------------------------------------------------------------------------------------------------------------//
    
    /**
     * Display all events and sessions from 2 weeks ago until eternity
     * sessions are grouped into rotas
     * rotas and events are merged into one list, sorted by start date
     */
    public function index()
    {
        // Get sessions
        //$sessions = $this->getUpcomingSessions();
        // Group sessions into rotas
        //$rotas = $this->getRotas($sessions);
        $rotas = Rotas::getUpcoming();
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
        
        $rota = new Rota($date);
        $sessions = $rota->sessions;
        //approximate start and end time of the next session
        //logic is: if no session so far for this day, then first session is same as last rotas first session
        //          otherwise, assume the next session starts after the previous one and is as long as the previous session.
        $latest = $rota->getLastSession();
        if($latest){
            // Already have a session for this date
            // We therefore assume that the next session will be right after the previous one and have equal duration.
            $newstarttime = new Carbon($latest->end_date);
            $newendtime = new Carbon($latest->start_date); 
            $newendtime = $newstarttime->copy()->addMinutes($newendtime->copy()->diffInMinutes($newstarttime->copy()));
            $newstarttime = new Carbon($latest->end_date);
        }else{
            // This is the first session for today
            // Get the latest Rota
            $lastSession = Sessions::orderBy('start_date','DESC')->first();
            $lastDate = new Carbon($lastSession->start_date);
            $lastRota = new Rota($lastDate->format('Y-m-d'));
            // Get the first session of that day
            $firstSession = $lastRota->getFirstSession();
            // Copy the start time from that session
            $oldstarttime = new Carbon($firstSession->start_date);
            $newstarttime = new Carbon($date.' 00:00:00');
            $newstarttime->hour($oldstarttime->hour)->minute($oldstarttime->minute)->second($oldstarttime->second);
            // Copy the end time from that session
            $oldendtime = new Carbon($firstSession->end_date);
            $newendtime = new Carbon($date.' 23:59:59');
            $newendtime->hour($oldendtime->hour)->minute($oldendtime->minute)->second($oldendtime->second);
            
        }
        // Convert to the right time format, so that the date-time-picker is happy
        $newstarttime = $newstarttime->format('H:i');
        $newendtime = $newendtime->format('H:i');
        // Get the events for this date
        $events = Event::orderBy('start_date')->where('start_date','<=',$date)->where('end_date','>=',$date)->get();
        // Finally show the blade...
        return view('rota.newsession', compact('date','sessions','newstarttime','newendtime','events'));
    }

     /**
     * Show the form for sending the email for the rota
     *
     * @return \Illuminate\Http\Response
     */
    public function createmail($date)
    {
        // Get the sessions for this date
        $rota = new Rota($date);
        $sessions = $rota->sessions;
        // Finally show the blade...
        return view('rota.mail', compact('date','sessions'));
    }
    
    //// CONTROLLER ACTIONS ////
    //---------------------------------------------------------------------------------------------------------------//
    
    public function sendmail($date)
    {
        $message =   $reject_message = request()->validate([
            'comment' => 'max:255']);
        // Get the sessions for this date
        $rota = new Rota($date);
        $sessions = $rota->sessions;
        $message['date'] = $date;

        // Send email
        try{
            if(env('APP_URL') === 'http://localhost'){
                // Only Svitlana, Andrew, and Lasse now for testing purposes
                $usersTo = '3dprint.soton@gmail.com';
                $usersCC = staff::orderBy('last_name')->where('id',1)->orWhere('id',2)->orWhere('id',7)->pluck('email');
            }else{
                // Send to all except for the Former members
                $usersTo = staff::orderBy('last_name')->where('role','Demonstrator')->pluck('email');
                $usersCC = staff::orderBy('last_name')->where('role','!=','Former member')->where('role','!=','Demonstrator')->pluck('email'); 
                //TODO: pluck name and email, so that the message is send with the names covering the many emails
            }
            Mail::to($usersTo)->cc($usersCC)->queue(new RotaMail($sessions, $message));

            // Notify that the user of success
            notify()->flash('The email has been sent' , 'success', [
                'text' => 'The rota has been successfully sent to all 3D printing service staff. Please remember to update the rota in case people become unavailable!',
            ]);
        }catch(\Exception $e){
            notify()->flash('Error!', 'error', [
                'text' => 'There has been an error with our email server. Please send out the rota manually!',
            ]);
        }

        return redirect('/rota');

        // Send email with the sessions and input
    }

    
}
