<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
    protected $guarded = [];
    public function staff_approved()
    {
        return $this->belongsTo(staff::class, 'job_approved_by');
    }
    public function staff_finished()
    {
        return $this->belongsTo(staff::class, 'job_finished_by');
    }
    public function prints(){
        return $this->belongsToMany(Prints::class);
    }
}
