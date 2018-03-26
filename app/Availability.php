<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use phpDocumentor\Reflection\Types\Null_;
/**
 * one session in the workshop (i.e. Wed,28/03/2018 9am till 12pm)
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
