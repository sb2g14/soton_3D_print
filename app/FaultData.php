<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FaultData extends Model
{
    protected $guarded = [];
    public function FaultUpdates()

    {

        return $this->hasMany(FaultUpdates::class);

    }

    public function Printers()
    {
        return $this->belongsTo(Printers::class);
    }
}
