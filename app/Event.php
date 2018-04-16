<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Null_;
/**
 * one session in the workshop (i.e. Wed,28/03/2018 9am till 12pm)
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
