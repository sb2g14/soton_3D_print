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
            $start = $r[0]->start_date;
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
    private function getRotas($sessions){
        $rotas = [];
        $rota = [];
        $lastdate = "";
        foreach($sessions as $s){
            if($s->date() !== $lastdate){
                //new rota started
                if($rota != []){
                    //append old rota
                    $rotas[] = $rota;
                }
                //reset variables
                $rota = [];
                $lastdate = $s->date();
            }
            //append session to rota
            $rota[] = $s;
        }
        //append last rota
        if($rota != []){
            //append old rota
            $rotas[] = $rota;
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
        $sessions = $this->getUpcomingSessions();
        //merge sessions into rota groups
        $rotas = $this->getRotas($sessions);
        // get upcoming events
        $events = $this->getUpcomingEvents();
        // merge rotas and events
        $items = $this->mergeItems($rotas,$events);
        
        // Get Closure period and mark as disabled dates
        $closures = $this->getClosureAsString();
        $user = Auth::user()->staff;
        
        return view('rota.index', compact('sessions','user','items','closures'));
    }
}
