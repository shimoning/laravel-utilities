<?php

namespace Shimoning\LaravelUtilities\Rules;

use Illuminate\Contracts\Validation\Rule;

class Time implements Rule
{
    public $allowOver24 = false;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($options = null)
    {
        if ($options) {
            $this->allowOver24 = !empty($options['allowOver24']);
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
        return $this->allowOver24
            ? preg_match('/^(\d+):([0-5]?[0-9])(:[0-5]?[0-9])?$/', $value)
            : preg_match('/^([01]?[0-9]|2[0-3]):([0-5]?[0-9])(:[0-5]?[0-9])?$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->allowOver24
            ? trans('shimoning-validation.time_over_24')
            : trans('shimoning-validation.time');
    }
}
