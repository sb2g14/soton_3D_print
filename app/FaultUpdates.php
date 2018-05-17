<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FaultUpdates
 * This class handles updates/ comments on printer-related issues (FaultData)
 *
 * @package App
 * @property string $users_name ???
 * @property string $body update message
 * @property string $printer_status new printer status based on this update
 * @property int $days_out_of_order number of days the printer has been out of order???
 **/
class FaultUpdates extends Model
{
    protected $guarded = [];
    
    /** the issue this is an update of **/
    public function FaultData() {
        return $this->belongsTo(FaultData::class);
    }
    
    /** the member of staff who posted this update **/
    public function staff()
    {
        return $this->belongsTo(staff::class,'staff_id');
    }

}
