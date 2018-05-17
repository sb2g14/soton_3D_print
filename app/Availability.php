<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Null_;

/**
 * An Availability is the status of one demonstrator for a particular Session. 
 *
 * @package App
 * @property string $status the type of event (any of "available", "tentative", "busy", "away")
 **/
class availability extends Model
{
    protected $guarded = [];
    
    /** the session the availability is indicated for **/
    public function sessions()
    {
        return $this->belongsTo(sessions::class);
    }

    /** the member of staff indicating their availability **/
    public function staff()
    {
        return $this->belongsTo(staff::class);
    }
    
}
