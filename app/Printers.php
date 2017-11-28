<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
    public function changePrinterStatus()
    {
            $print = $this->prints->last();
            $job = $print->jobs->last();
            list($h, $i, $s) = explode(':', $print->time);
            if (Carbon::now('Europe/London')->gte(Carbon::parse($job->approved_at)->addHour($h)->addMinutes($i))) {
                //$this->update(array('in_use' => 0));
                if($job->requested_online == 0){
                    $job->update(array('status' => 'Success', 'job_finished_by' => staff::where('email','=','3DPrintFEE@soton.ac.uk')->first()->id));
                }
            }
    }
}
