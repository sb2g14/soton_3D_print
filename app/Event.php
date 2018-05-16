<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Null_;

/**
 * Class event
 * an event is an independent occurence in time
 *
 * we use this model to indicate events useful to the workshop
 * this includes exam times, public holidays and training sessions
 *
 * @package App
 * @property Carbon $start_date date and time when the event starts
 * @property Carbon $end_date date and time when the event ends
 * @property string $name a human readable name to display for the event
 * @property string $type the type of event (any of "academic", "holidays", "closure", "internal")
 */
class event extends Model
{
    protected $guarded = [];
    
    /**returns a html representation of the events start and end date**/
    public function dateString(){
        $ans = Carbon::parse($this->start_date)->format('d/m/Y');
        if(Carbon::parse($this->start_date)->format('d/m/Y') != Carbon::parse($this->end_date)->format('d/m/Y')){
            $ans = $ans." &ndash; ".Carbon::parse($this->end_date)->format('d/m/Y');
        }
        return $ans;
    }
    
}
