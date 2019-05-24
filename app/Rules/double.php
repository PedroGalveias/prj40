<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class double implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return is_double($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O :attribute tem de ser um número!';
    }
}
