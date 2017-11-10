<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class SotonID implements Rule
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
        return (preg_match("/^[1]{1}/", $value) & strlen($value) === 8) |
            (preg_match("/^[2345]{1}/", $value) & strlen($value) === 9);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Check if the soton id is correct';
    }
}
