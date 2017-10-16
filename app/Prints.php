<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prints extends Model
{
    protected $guarded = [];
    public function staff_started()
    {
        return $this->belongsTo(staff::class, 'print_started_by');
    }
    public function staff_finished()
    {
        return $this->belongsTo(staff::class, 'print_finished_by');
    }
    public function printer()
    {
        return $this->belongsTo(Printers::class, 'printers_id');
    }
    public function jobs(){
        return $this->belongsToMany(Jobs::class);
    }

}
