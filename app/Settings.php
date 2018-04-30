<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use phpDocumentor\Reflection\Types\Null_;
use App\Event;
/**
 * one session in the workshop (i.e. Wed,28/03/2018 9am till 12pm)
 * A session is the smallest instance of the service work time. It has a start and an end time.
 * A session can be either public, meaning that anyone can attend it,
 * or private, meaning that only invited people should attend it.
 * Each session requires a certain number of demonstrators to run it.
 * All sessions in one day form a rota (See RotaController).
 */
class settings extends Model
{
    protected $guarded = [];
    public function value()
    {
        $ans = $this->value;
        if ($this->type === "boolean"){
            if($ans === "1" || $ans === "True"){
                $ans = True;
            }else{
                $ans = False;
            }
        }else if ($this->type === "number"){
            $ans = float($ans);
        }
        return $ans;

    }
    
}
