<?php

namespace Shimoning\LaravelUtilities\Rules;

use Illuminate\Contracts\Validation\Rule;

class HexColor implements Rule
{
    /**
     * 先頭に # をつける
     *
     * @var boolean
     */
    public $withHash = true;

    /**
     * rrggbb を受け付ける
     *
     * @var boolean
     */
    public $allowLong = true;

    /**
     * rgb を受け付ける
     *
     * @var boolean
     */
    public $allowShort = true;

    const BASE_REGEX = '[a-zA-Z0-9]';
    const LONG_REGEX = self::BASE_REGEX + '{6}';
    const SHORT_REGEX = self::BASE_REGEX + '{3}';
    const HASH = '#';

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($options)
    {
        if (isset($options['withHash'])) {
            $this->withHash = (bool)$options['withHash'];
        }
        if (isset($options['allowLong'])) {
            $this->allowLong = (bool)$options['allowLong'];
        }
        if (isset($options['allowShort'])) {
            $this->allowShort = (bool)$options['allowShort'];
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
        $regex = '';
        if ($this->allowLong && $this->allowShort) {
            $regex = '(' . self::LONG_REGEX . '|' . self::SHORT_REGEX . ')';
        } else if ($this->allowLong) {
            $regex = self::LONG_REGEX;
        } else if ($this->allowShort) {
            $regex = self::SHORT_REGEX;
        } else {
            return false;
        }

        if ($this->withHash) {
            $regex = self::HASH . $regex;
        }
        return preg_match('/^' . $regex . '$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('laravel-utilities::validation.hex-color');
    }
}
