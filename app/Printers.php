<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use phpDocumentor\Reflection\Types\Null_;

class printers extends Model
{
//    protected $fillable = [
//        'serial_no',
//        'printer_type',
//        'printer_status'
//    ];
    protected $guarded = [];
    public function printing_data()
    {

        return $this->hasMany(printing_data::class);

    }
    public function prints()
    {

        return $this->hasMany(Prints::class);

    }
    public function posts()
    {

        return $this->hasMany(posts::class);

    }
    public function fault_data()
    {

        return $this->hasMany(FaultData::class);

    }
    public function changePrinterStatus()
    {
            /** @var  $this is the printer */
            //find last print for this printer
            $print = $this->prints->last();
            //get the (last) job related to this print
            $job = $print->jobs->last();
            //get print runtime
            list($h, $i, $s) = explode(':', $print->time);
            //check if time since print started is greater than print time
            if (Carbon::now('Europe/London')->gte(Carbon::parse($job->approved_at)->addHour($h)->addMinutes($i))) {
                //don't apply this to online prints
                if($job->requested_online == 0){
                    //set this printer to not be used anymore
                    $this->update(array('in_use' => 0));
                    //set job status to Success & completed by system
                    $job->update(array('status' => 'Success', 'job_finished_by' => staff::where('email','=','3DPrintFEE@soton.ac.uk')->first()->id));
                    //set print status to Success & completed by system
                    $print->update(array('status' => 'Success', 'print_finished_by' => staff::where('email','=','3DPrintFEE@soton.ac.uk')->first()->id));
                }
            }
    }
    public function calculateTotalTime($parameter)
    {
        $total_minutes = 0;
        foreach ($parameter as $print){
            if($print->time){
                list($h, $i, $s) = explode(':', $print->time);
                $minutes = $h*60 + $i;
                $total_minutes = $total_minutes + $minutes;
            }
        }
        return $total_minutes;
    }
    public function calculateTotalTimeSuccess()
    {
        return $this->calculateTotalTime($this->prints->where('status','Success')->where('purpose','Use'));
    }
    public function calculateTotalTimeOnLoan()
    {
        $total_minutes = 0;
        foreach ($this->prints->where('purpose','Loan') as $print) {
                $minutes = $print->updated_at->diffInMinutes($print->created_at);
                $total_minutes = $total_minutes + $minutes;
        }
        return $total_minutes;
    }
    public function calculateTotalTimeBroken()
    {
        $total_minutes = 0;
        foreach ($this->fault_data as $issue) {
            if ($issue->resolved === 0) {
                $minutes = Carbon::now('Europe/London')->diffInMinutes($issue->created_at);
                $total_minutes = $total_minutes + $minutes;
            } else {
                $minutes = Carbon::parse($issue->resolved_at)->diffInMinutes($issue->created_at);
                $total_minutes = $total_minutes + $minutes;
            }
        }
        return $total_minutes;
    }
    
    /** gets the date and time of the last time this printer was updated**/
    public function lastUpdateDatetime()
    {
        $lastPrint=$this->prints()->orderBy('finished_at', 'desc')->where('status','!=', 'Waiting')->first();
        $lastIssue=$this->fault_data()->where('resolved',1)->orderBy('resolved_at','desc')->first();
        $lastIssueUpdate = \App\FaultData::orderBy('fault_updates.created_at','desc')
            ->crossJoin('fault_updates', 'fault_datas.id', '=', 'fault_updates.fault_data_id')
            ->where('fault_datas.printers_id', $this->id)
            ->select('fault_updates.*')
            ->first();

        
        $allDates = [];
        $allDates[] = \Carbon\Carbon::parse($this->updated_at);
        if($lastPrint){
            $allDates[] = \Carbon\Carbon::parse($lastPrint->finished_at);
        }
        if($lastIssue){
            $allDates[] = \Carbon\Carbon::parse($lastIssue->resolved_at);
        }
        if($lastIssueUpdate){
            $allDates[] = \Carbon\Carbon::parse($lastIssueUpdate->created_at);
        }
        // Compare maximums of pairs of timestamps
        $max = \Carbon\Carbon::create(1990, 1, 1, 0);
        foreach($allDates as $date){
            $max=$max->max($date);
        }
        return $max;
    }
    
    /** gets the name of the last staff updating this printer as a string, otherwise returns "N/A"**/
    public function lastUpdateStaff()
    {
        $lastPrint=$printer->prints()->orderBy('updated_at', 'desc')->where('status','!=', 'Waiting')->first();
        $lastIssue=$printer->fault_data()->where('resolved',1)->orderBy('resolved_at','desc')->first();
        $lastIssueUpdate = \App\FaultData::orderBy('fault_updates.updated_at','desc')
        ->crossJoin('fault_updates', 'fault_datas.id', '=', 'fault_updates.fault_data_id')
        ->where('fault_datas.printers_id', $printer->id)
        ->select('fault_updates.*')
       ->first();

        $nullDate = \Carbon\Carbon::create(1990, 1, 1, 0);
        if(!$lastPrint)
        {
            $tstmp1 = $nullDate;
        } else {
            $tstmp1 = $lastPrint->updated_at;
        }
        if(!$lastIssue)
        {
            $tstmp2 = $nullDate;
        } else {
            $tstmp2 = \Carbon\Carbon::parse($lastIssue->resolved_at);
        }
        if(!$lastIssueUpdate)
        {
            $tstmp3 = $nullDate;
        } else {
            $tstmp3 = $lastIssueUpdate->updated_at;
        }
        // Compare maximums of pairs of timestamps
        $max=$tstmp1->max($tstmp2)->max($tstmp3);
        
        if($max === $nullDate){
            $ans = "N/A";
        }else{
            if($tstmp1 === $max){
                $ans = $lastPrint->staff_started->name();
            }elseif($tstmp2 === $max){
                $ans = $lastIssue->issue_resolved->name();
            }elseif($tstmp3 === $max){
                $ans = $lastIssueUpdate->users_name;
            }
        }
        return $ans;
    }
}
