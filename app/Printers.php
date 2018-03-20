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
}
