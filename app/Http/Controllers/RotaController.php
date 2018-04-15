<?php

namespace App\Http\Controllers;

use App\Rota;
use App\Rotas;
use App\staff;
use App\Sessions;
use App\Availability;
use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use Carbon\Carbon;
use App\Mail\RotaMail;
use Illuminate\Support\Facades\Mail;
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

        $this->middleware('auth')->except('openingHours');

    }
    
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
        //logic is: if no session so far for this day, then first session is 9am till 12pm
        //          otherwise, assume the next session starts after the previous one and is as long as the previous session.
        $latest = $rota->getLastSession();
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
        // need to convert to the right time format, so that the date-time-picker is happy
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
            // Send an email to the 3dprint account an cc all the recipients
            $recipient = '3dprint.soton@gmail.com';
            // Only Svitlana and Andrew now for testing purposes
            $users = Staff::where('id',1)->orWhere('id',2)->pluck('email');
            Mail::to($recipient)->cc($users)->queue(new RotaMail($sessions, $message));

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
}
