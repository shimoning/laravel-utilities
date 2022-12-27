<?php

namespace Shimoning\LaravelUtilities\Rules;

use Illuminate\Contracts\Validation\Rule;

class Alpha implements Rule
{
    /**
     * 半角スペースを受け付ける
     *
     * @var bool
     */
    public $withSpace = false;

    /**
     * @param array|null
     * @return void
     */
    public function __construct($options = null)
    {
        if (isset($options['withSpace'])) {
            $this->withSpace = (bool)$options['withSpace'];
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
        return preg_match('/^[A-Za-z' . ($this->withSpace ? ' ' : '' ) . ']+$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('laravel-utilities::validation.alpha');
    }
}
