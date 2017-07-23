<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FaultUpdates extends Model
{
    protected $guarded = [];
    public function FaultData() {
        return $this->belongsTo(FaultData::class);
    }

}
