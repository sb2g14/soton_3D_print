<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use phpDocumentor\Reflection\Types\Null_;
/**
 * An Availability is the status of one demonstrator for a particular Session. The status can be available, tentative, busy, or away.
 */
class availability extends Model
{
    protected $guarded = [];
    public function sessions()
    {

        return $this->belongsTo(sessions::class);

    }
    public function staff()
    {

        return $this->belongsTo(staff::class);

    }
    
}
