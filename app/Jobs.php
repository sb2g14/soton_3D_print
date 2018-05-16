<?php

namespace App;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Jobs
 * A job is a request by a customer (student or staff) to occupy one or more 
 * 3D printers and print one or more parts using a certain amount of material.
 * A job therefore contain one or more prints. A job can be a request for an
 * online manager to print parts for the customer or a request of the customer
 * to print parts themselves in the workshop.
 *
 * @package App
 * @property float $total_material_amount   //TODO: should be material_amount
 * @property float $total_price             //TODO: should be price
 * @property string $total_duration         //TODO: should be print_time
 * @property string $paid
 * @property string $payment_category
 * @property string $cost_code
 * @property string $use_case               //TODO: what do we store here again?
 * @property string $job_approved_comment   //TODO: should be approved_comment
 * @property int $customer_id
 * @property string $customer_name
 * @property string $customer_email
 * @property int $requested_online          //TODO: should be online
 * @property string $status
 * @property datetime $created_at
 * @property datetime $updated_at
 * @property datetime $approved_at
 * @property string $claim_id               //TODO: should be dropoff_id
 * @property string $claim_passcode         //TODO: should be dropoff_passcode
 * @property string $job_title              //TODO: should be title
 * @property string $budget_holder
 * @property datetime $accepted_at
 * @property datetime $finished_at
 **/
class Jobs extends Model
{
    // Define model attributes that should not be mass assignable
    protected $guarded = [];
    
    //// CONNECTIONS TO OTHER MODELS/ SQL TABLE LINKS ////
    //---------------------------------------------------------------------------------------------------------------//
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
    public function prints(){
        return $this->belongsToMany(Prints::class);
    }
    
    //// FUNCTIONS TO CALCULATE AND PRE-FORMAT CERTAIN VALUES ////
    //---------------------------------------------------------------------------------------------------------------//
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
    
    //// FUNCTIONS TO CHANGE THE STATE OF THE MODEL ////
    //---------------------------------------------------------------------------------------------------------------//
    /** Staff to approve a job **/
    public function approve(array $changes = []){
        // Change the status
        $this->update([
            'status' => 'Approved',
            'approved_at' => Carbon::now('Europe/London'),
            'job_approved_by' => Auth::user()->staff->id
        ]);
        // Update the Job
        $this->update($changes);
    }
    /** Customer to accept a job **/
    public function accept(){
        // Update the Job
        $this->update([
            'status' => 'In Progress',
            'accepted_at' => Carbon::now('Europe/London')
        ]);
    }
    /** Staff to finish a job **/
    public function finish(string $status, array $changes = []){
        // Validate input
        if($status !== "Success" && $status !== "Failed"){
            throw new Exception('Invalid job completion flag. Expected "Failed" or "Success"');
        }
        // Change the status
        $this->update([
            'status' => $status,
            'finished_at' => Carbon::now('Europe/London'),
            'job_finished_by' => Auth::user()->staff->id
        ]);
        // Update the Job
        $this->update($changes);
    }
    /** Deletes a job from the database, leaving no trace of it. This should never be called for started jobs! **/
    public function deleteAll(){
        
        // Delete associated print previews or prints
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
