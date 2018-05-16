<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FaultUpdates
 * This class handles updates/ comments on printer-related issues (FaultData)
 **/
class FaultUpdates extends Model
{
    protected $guarded = [];
    public function FaultData() {
        return $this->belongsTo(FaultData::class);
    }
    public function staff()
    {
        return $this->belongsTo(staff::class,'staff_id');
    }

}
