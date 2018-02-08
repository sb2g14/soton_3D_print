<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;
use App\cost_code;

class UseCase implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Check that the cost code is in data base and is active
        $nowDate = new Carbon();
        $nowDate = $nowDate->toDateString();
        $query = cost_code::where('shortage','=',strtoupper($value))->where('expires','>',$nowDate)->count();
        if ($query >= 1){
            return true;
        } else {
            // Otherwise, accept a cost code
            return (bool) preg_match('/^(\d{9})$/', $value);
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Please provide a valid module name or cost code';
    }
}
