<?php

namespace Shimoning\LaravelUtilities\Rules;

use Illuminate\Contracts\Validation\Rule;

class Hiragana implements Rule
{
    public $withSpace = false;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($options = null)
    {
        if ($options) {
            $this->withSpace = !empty($options['withSpace']);
        }
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
        return preg_match('/^[ぁ-んー' . ($this->withSpace ? ' 　' : '' ) . ']+$/u', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('laravel-utilities::validation.hiragana');
    }
}
