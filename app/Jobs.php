<?php

namespace App;

use Carbon\Carbon;
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
    public function approved_at()
    {
        return new Carbon($this->approved_at);
    }
    public function accepted_at()
    {
        return new Carbon($this->accepted_at);
    }
    public function finished_at()
    {
        return new Carbon($this->finished_at);
    }
    public function prints(){
        return $this->belongsToMany(Prints::class);
    }
}
