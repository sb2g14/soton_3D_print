<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FaultData
 * This class handles printer-related issues
 *
 * @package App
 * @property string $serial_number Printer serial number???
 * @property string $printer_status new printer status based on this issue
 * @property string $body issue message
 * @property string $title issue title
 * @property boolean $resolved has this issue been resolved?
 * @property string $message_resolved message when issue is being resolved
 * @property Carbon $resolved_at datetime when the issue was resolved
 **/
class FaultData extends Model
{
    protected $guarded = [];
    
    /** updates for this printer issue **/
    public function FaultUpdates()
    {
        return $this->hasMany(FaultUpdates::class);
    }
    
    /** the printer affected by this issue **/
    public function Printers()
    {
        return $this->belongsTo(Printers::class);
    }
    
    /** the member of staff who raised this issue **/
    public function issue_created()
    {
        return $this->belongsTo(staff::class, 'staff_id_created_issue');
    }
    
    /** the member of staff who resolved this issue **/
    public function issue_resolved()
    {
        return $this->belongsTo(staff::class, 'staff_id_resolved_issue');
    }
}
