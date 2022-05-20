<?php

namespace Shimoning\LaravelUtilities\Rules;

use Illuminate\Contracts\Validation\Rule;
use Shimoning\LaravelUtilities\Traits\BooleanTrait;

class Boolean implements Rule
{
    use BooleanTrait;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return ! \is_null($this->toBoolean($value));
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
