<?php

namespace App\Http\Controllers\Traits;

use Carbon\Carbon;
use App\Sessions;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

/**
 * This Trait provides workshop related functions
 **/
trait WorkshopTrait
{

    /** Checks if the workshop is open at the given date and time **/
    private static function isOpenAt($datetime){;
        $Nsessions = Sessions::where('start_date','<=',$datetime)->where('end_date','>=',$datetime)->count();
        if($Nsessions > 0){
            return true;
        }
        return false;
    }
    
    /** Checks if the workshop is open now **/
    private function WorkshopisOpen(){
        $datetime = new Carbon();
        return $this->isOpenAt($datetime->toDateTimeString());
    }
    
    /** Checks if the workshop is open now **/
    public static function isOpen(){
        $datetime = new Carbon();
        return self::isOpenAt($datetime->toDateTimeString());
    }
}
