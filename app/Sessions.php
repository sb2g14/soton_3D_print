<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use phpDocumentor\Reflection\Types\Null_;
use App\Event;
/**
 * one session in the workshop (i.e. Wed,28/03/2018 9am till 12pm)
 * A session is the smallest instance of the service work time. It has a start and an end time.
 * A session can be either public, meaning that anyone can attend it,
 * or private, meaning that only invited people should attend it.
 * Each session requires a certain number of demonstrators to run it.
 * All sessions in one day form a rota (See RotaController).
 */
class sessions extends Model
{
    protected $guarded = [];
    public function rota()
    {

        return $this->belongsTo(rota::class);

    }
    public function staff()
    {

        return $this->belongsToMany(staff::class);

    }
    public function availability()
    {

        return $this->hasMany(Availability::class);

    }
    public function start_time()
    {

        $t = new Carbon($this->start_date);
        return $t->format('H:i');

    }
    public function end_time()
    {

        $t = new Carbon($this->end_date);
        return $t->format('H:i');

    }
    public function date()
    {

        $t = new Carbon($this->start_date);
        return $t->toDateString();

    }
    public function events()
    {

        $t1 = new Carbon($this->start_date);
        $t2 = new Carbon($this->end_date);
        $events = Event::where('start_date','<=',$t1)->where('end_date','>=',$t2)->get();
        return $events;

    }
    
    public function timeString()
    {
        return $this->start_time()." &ndash; ".$this->end_time();
    }
    
    public function minutes()
    {
        $t1 = new Carbon($this->start_date);
        $t2 = new Carbon($this->end_date);
        return $t1->diffInMinutes($t2);
    }
    
}
