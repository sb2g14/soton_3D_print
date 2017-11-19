<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class text implements Rule
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
        return (bool) preg_match("/^[a-z-A-Z-0-9 ,.-]+$/m", $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Only standard text characters are allowed';
    }
}
