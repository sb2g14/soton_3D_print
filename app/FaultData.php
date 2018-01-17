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
    public function issue_created()
    {
        return $this->belongsTo(Staff::class, 'staff_id_created_issue');
    }
    public function issue_resolved()
    {
        return $this->belongsTo(Staff::class, 'staff_id_resolved_issue');
    }
}
