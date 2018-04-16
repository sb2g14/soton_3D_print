<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Prints extends Model
{
    protected $guarded = [];
    public function staff_started()
    {
        return $this->belongsTo(staff::class, 'print_started_by');
    }
    public function staff_finished()
    {
        return $this->belongsTo(staff::class, 'print_finished_by');
    }
    public function printer()
    {
        return $this->belongsTo(Printers::class, 'printers_id');
    }
    public function jobs(){
        return $this->belongsToMany(Jobs::class);
    }
    /**returns a string how much time is left on this print**/
    public function timeRemain(){
        // Separate hours from minutes and seconds in printing time
        list($h, $i, $s) = explode(':', $this->time);
        // Get time the print started
        //$time_approved = new Carbon($this->jobs()->first()->approved_at);
        $time_approved = $this->created_at; //TODO: can use updated at unless completed?
        // Get time the print will finish
        $time_finish = $time_approved->addHour($h)->addMinutes($i);
        // Format as string
        if ($time_finish->gte(Carbon::now('Europe/London'))){
            $ans = $time_finish->diffInHours(Carbon::now('Europe/London')).":".sprintf('%02d', $time_finish->diffInMinutes(Carbon::now('Europe/London'))%60);
            //$ans = $time_finish->diffForHumans(null,true,true,6);
        }else{
            $ans = "completed";
        }
        return $ans;
    }
}
