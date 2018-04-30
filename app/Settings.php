<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use phpDocumentor\Reflection\Types\Null_;
use App\Event;
/**
 * A global setting that needs to be editable by users
 * a setting consists of a key and a value, allowing you to load the settings by key.
 * the type allows you to quickly format the value by using ->value()
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
