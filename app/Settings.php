<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Null_;

/**
 * A global setting that needs to be editable by users
 * a setting consists of a key and a value, allowing you to load the settings by key.
 * the type allows you to quickly format the value by using ->value()
 *
 * @package App
 * @property string $key descriptor of the setting
 * @property string $value value of the setting variable
 * @property string $type datatype of the value
 **/
class settings extends Model
{
    protected $guarded = [];
    
    /** get the value of this setting as the correct type**/
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
            $ans = (float)$ans;
        }
        return $ans;

    }
    
}
