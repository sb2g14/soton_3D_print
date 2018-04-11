<?php

namespace App;

use App\Sessions;
use App\Rota;
use Carbon\Carbon;
use phpDocumentor\Reflection\Types\Null_;
/**
 * one rota (i.e. Wed,28/03/2018 with 3 sessions from 9am till 6pm)
 */
class Rotas
{
    
    /** gets the upcoming sessions from the database**/
    public static function getUpcomingSessions(){
        $t1 = new Carbon();
        $t1 = $t1->subWeeks(2)->hour(0)->minute(0)->second(0);
        $sessions = Sessions::with('staff')->orderBy('start_date')->where('start_date','>=',$t1)->get(); 
        return $sessions;   
    }
    
    /** gets future sessions from the database**/
    public static function getFutureSessions(){
        $t1 = new Carbon();
        $t1 = $t1->hour(0)->minute(0)->second(0);
        $sessions = Sessions::with('staff')->orderBy('start_date')->where('start_date','>=',$t1)->get(); 
        return $sessions;   
    }
    
    /** groups sessions into rotas **/
    private static function getRotas($sessions){
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
    
    public static function getUpcoming(){
        //TODO: can make this smarter by only getting the dates?
        $sessions = self::getUpcomingSessions();
        $rotas = self::getRotas($sessions);
        return $rotas;   
    }
    
    /** 
     * find Rota for the given date 
     * equivalent of find(id) for eloquent models
     **/
    public static function find($date){
        return new Rota($date);
    }
    
}
