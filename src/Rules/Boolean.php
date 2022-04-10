<?php

namespace Shimoning\LaravelUtilities\Rules;

use Illuminate\Contracts\Validation\Rule;

class Boolean implements Rule
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
        return ! \is_null(\filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('laravel-utilities::validation.boolean');
    }
}
