<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use phpDocumentor\Reflection\Types\Null_;
use App\Event;
/**
 * one session in the workshop (i.e. Wed,28/03/2018 9am till 12pm)
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
    
}
