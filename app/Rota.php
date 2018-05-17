<?php

namespace App;

use App\Sessions;
use Carbon\Carbon;
use phpDocumentor\Reflection\Types\Null_;
/**
 * one rota (i.e. Wed,28/03/2018 with 3 sessions from 9am till 6pm)
 */
class Rota
{

    public $date;
    public $start_date;
    public $sessions;
    
    /** contructor initiating the class
     * takes $date as a string of format yyy-mm-dd
     **/
    public function __construct($date){
        $this->date = $date;
        $this->sessions = $this->get_sessions();
        if(count($this->sessions)>0){
            $this->start_date = $this->sessions[0]->start_date;
        }else{
            $this->start_date = null;
        }
    }
    
    /** return all sessions during this rota**/
    private function get_sessions()
    {
        $t1 = new Carbon($this->date.' 0:00:00');
        $t2 = new Carbon($this->date.' 23:59:59');
        $sessions = Sessions::where('start_date','>=',$t1)->where('start_date','<=',$t2)->get();
        return $sessions;
    }
    
    /** return the last session during this rota **/
    public function getLastSession(){
        $sessions = $this->sessions; //->orderBy('start_date','desc')->first();
        $sessions = collect($sessions)->sortByDesc('start_date');
        if(count($sessions->values())>0){
            return $sessions->values()->first();
        }
        return null;
    }
    
    /** return the first session during this rota **/
    public function getFirstSession(){
        $sessions = $this->sessions; //->orderBy('start_date','desc')->first();
        $sessions = collect($sessions)->sortBy('start_date');
        if(count($sessions->values())>0){
            return $sessions->values()->first();
        }
        return null;
    }
    
}
