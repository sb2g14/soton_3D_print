<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CustomerNameValidation implements Rule
{
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
        return (bool) preg_match("/^[a-z ,.'-]+$/i", $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Only letters and hyphens are allowed';
    }
}
