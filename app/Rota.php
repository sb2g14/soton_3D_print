<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use phpDocumentor\Reflection\Types\Null_;
/**
 * one rota (i.e. Wed,28/03/2018 with 3 sessions from 9am till 6pm)
 */
class rota extends Model
{
//    protected $fillable = [
//        'serial_no',
//        'printer_type',
//        'printer_status'
//    ];
    protected $guarded = [];
    public function sessions()
    {

        return $this->hasMany(session::class);

    }
    public function startDate()
    {
        //TODO: get related sessions and select first start date
    }
    public function endDate()
    {
        //TODO: get related sessions and select last end date
    }
}
