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
    /** Staff to approve a job **/
    private function approve(string $comment = ""){
        // Update the Job
        $this->update([
            'status' => 'Approved',
            'approved_at' => Carbon::now('Europe/London'),
            'job_approved_by' => Auth::user()->staff->id,
            'job_approved_comment' => $comment
        ]);
    }
    /** Customer to accept a job **/
    private function accept(){
        // Update the Job
        $this->update([
            'status' => 'In Progress',
            'accepted_at' => Carbon::now('Europe/London')
        ]);
    }
    /** Staff to finish a job **/
    private function finish(string $status){
        // Validate input
        if($status !== "Success" && $status !== "Failed"){
            throw new Exception('Invalid job completion flag. Expected "Failed" or "Success"');
        }
        // Update the Job
        $this->update([
            'status' => $status,
            'finished_at' => Carbon::now('Europe/London'),
            'job_finished_by' => Auth::user()->staff->id
        ]);
    }
    /** Deletes a job from the database, leaving no trace of it. This should never be called for started jobs! **/
    private function deleteAll(){
        
        // Delete associated print previews
        $prints = $this->prints;
        foreach($prints as $print)
        {
            $this->prints()->detach($print->id); //Break connection with job
            $print->delete(); // Delete print previews
        }
        
        // Delete associated messages //TODO: simplify this!
        $messages = $this->messages;
        foreach($messages as $message)
        {
            $this->messages()->detach($message->id); //Break connection with job
            $message->delete(); // Delete message
        }
        
        $this->delete(); // Delete job
    }
}
