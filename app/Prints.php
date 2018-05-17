<?php

namespace App;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Prints
 * A print descripes a single print process on a single 3D printer. 
 * Several parts may be printed together in one print. This means that
 * a print can be for several jobs.
 *
 * @package App
 * @property string $purpose 'Use' or 'Loan'    //TODO: should be 'Use' or 'Preview' and loans to be put in separate table
 * @property string $time                       //TODO: should be duration
 * @property float $material_amount
 * @property string $material_type
 * @property string $material_colour
 * @property float $price                       //TODO: should be cost
 * @property string $print_comment              //TODO: should be approved_comment
 * @property string $status
 * @property datetime $created_at date and time the print was first stored in the database
 * @property datetime $updated_at date and time the print was last updated in the database
 * @property datetime $finished_at date and time the print was completed/ finished
 **/
class Prints extends Model
{
    // Define model attributes that should not be mass assignable
    protected $guarded = [];
    
    //// CONNECTIONS TO OTHER MODELS/ SQL TABLE LINKS ////
    //---------------------------------------------------------------------------------------------------------------//
    public function staff_started()
    {
        return $this->belongsTo(staff::class, 'print_started_by'); //TODO: should be started_by
    }
    public function staff_finished()
    {
        return $this->belongsTo(staff::class, 'print_finished_by'); //TODO: should be finished_by
    }
    public function printer()
    {
        return $this->belongsTo(Printers::class, 'printers_id');
    }
    public function jobs(){
        return $this->belongsToMany(Jobs::class);
    }
    //// FUNCTIONS TO CALCULATE AND PRE-FORMAT CERTAIN VALUES ////
    //---------------------------------------------------------------------------------------------------------------//
    public function finished_at()
    {
        return new Carbon($this->finished_at);
    }
    public function durationMin(){ //TODO: refactor as "totalMin"
        //TODO: check it works and replace at appropriate places in controllers
        $finished_at = new Carbon($this->finished_at);
        $created_at = new Carbon($this->created_at);
        $expected_duration = explode(":", $this->time);
        $expected_duration = $expected_duration[0]*60 + $expected_duration[1];
        $duration = $this->finished_at ? $finished_at->diffInMinutes($created_at) : $expected_duration;
        return $duration;
    }
    /**returns a number how many minutes are done for this print**/
    public function completedMin(){
        // Separate hours from minutes and seconds in printing time
        list($h, $i, $s) = explode(':', $this->time);
        // Get time the print started
        if($this->jobs()->first()->requested_online == 0){
            $time_approved = new Carbon($this->jobs()->first()->approved_at);
        }else{
            $time_approved = $this->created_at;
        }
        // Get time the print will finish
        $time_finish = $time_approved->addHour($h)->addMinutes($i);
        // Compare to Now
        if ($time_finish->gte(Carbon::now('Europe/London'))){
            $ans = Carbon::now('Europe/London')->diffInMinutes($time_approved);
        }else{
            $ans = $this->durationMin();
        }
        return $ans;
    }
    /**returns a number how many minutes are left on this print**/
    public function remainMin(){
        $completed = $this->completedMin();
        $total = $this->durationMin();
        return $total - $completed;
    }
    /**returns a string how much time is left on this print**/
    public function timeRemain(){//TODO: refactor as "remainStr"
        // Separate hours from minutes and seconds in printing time
        list($h, $i, $s) = explode(':', $this->time);
        // Get time the print started
        //$time_approved = new Carbon($this->jobs()->first()->approved_at);
        $time_approved = $this->created_at; //TODO: can use updated at unless completed?
        // Get time the print will finish
        $time_finish = $time_approved->addHour($h)->addMinutes($i);
        // Format as string
        if ($time_finish->gte(Carbon::now('Europe/London'))){
            $ans = $time_finish->diffInHours(Carbon::now('Europe/London')).":".sprintf('%02d', $time_finish->diffInMinutes(Carbon::now('Europe/London'))%60);
            //$ans = $time_finish->diffForHumans(null,true,true,6);
        }else{
            $ans = "completed";
        }
        return $ans;
    }
    
    //// FUNCTIONS TO CHANGE THE STATE OF THE MODEL ////
    //---------------------------------------------------------------------------------------------------------------//
    /** Staff to approve a print **/
    public function approve(array $changes = []){
        // Change the status
        $this->update([
            'status' => 'Approved',
            'print_started_by' => Auth::user()->staff->id
        ]);
        // Update the Print
        $this->update($changes);
    }
    /** mark the print as in progress **/
    public function start(){
        // Update the Print
        $this->update([
            'status' => 'In Progress'
        ]);
        // Mark Printer as "in use"
        printers::where('id','=', $this->printer->id)->update(array('in_use'=> 1));
    }
    /** Staff to finish a print **/
    public function finish(string $status, array $changes = []){
        // Validate input
        if($status !== "Success" && $status !== "Failed"){
            throw new Exception('Invalid print completion flag. Expected "Failed" or "Success"');
        }
        // Change the status
        $this->update(array('status' => $status,
                            'finished_at' => Carbon::now('Europe/London'),
                            'print_finished_by' => Auth::user()->staff->id 
                            ));
        // Update the Print
        $this->update($changes);
        // Mark printer to be available again
        printers::where('id','=', $this->printers_id)->update(array('in_use'=> 0));
    }
}
