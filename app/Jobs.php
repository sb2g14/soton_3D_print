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
    public function messages()
    {
        return $this->hasMany(Messages::class, 'job_id');
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
    /**returns a boolean weather there are any unfinished prints or not**/
    public function hasActivePrint(){
        $prints = $this->prints()->where('status','!=','Failed')->where('status','!=','Success')->count();
        if($prints > 0){
            return true;
        }
        return false;
    }
    /**returns a number, how many minutes this job should take**/
    public function totalMin(){
        // Separate hours from minutes and seconds in job time
        list($h, $i, $s) = explode(':', $this->total_duration);
        $ans = (int)$h*60+(int)$i;
        return $ans;
    }
    /**returns an estimated number how many minutes have been printed for this job**/
    public function completedMin(){
        $prints = $this->prints()->where('status','!=','Failed')->get();
        $ans = 0;
        foreach($prints as $print){
            //get the completed print time divided by the number of jobs participating in this print (estimate)
            $ans += $print->completedMin() / $print->jobs()->count();
        }
        if($ans >= $this->totalMin()){
            $ans = $this->totalMin();
        }
        return $ans;
    }
    /**returns an estimated number how many minutes are left for this job**/
    public function remainingMin(){
        $completed = $this->completedMin();
        $total = $this->totalMin();
        return $total - $completed;
    }
}
