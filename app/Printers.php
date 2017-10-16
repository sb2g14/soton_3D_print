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
    public function changePrinterStatus()
    {
            $job = $this->printing_data->last();
            list($h, $i, $s) = explode(':', $job->time);
            if (Carbon::now('Europe/London')->gte($job->updated_at->addHour($h)->addMinutes($i))) {
                $this->update(array('in_use' => 0));
            }
    }
}
