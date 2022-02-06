<?php

namespace Shimoning\LaravelUtilities\Rules;

use Illuminate\Contracts\Validation\Rule;

// TODO: implement without city code mode
class PhoneNumber implements Rule
{
    /**
     * 国番号付き
     *
     * @var boolean
     */
    public $withCountryCode = false;

    /**
     * ハイフン必須
     *
     * @var boolean
     */
    public $hyphenRequired = false;

    /**
     * ハイフン禁止
     *
     * @var boolean
     */
    public $hyphenIgnored = false;

    /**
     * @param array|null
     * @return void
     */
    public function __construct($options = null)
    {
        if (isset($options['withCountryCode'])) {
            $this->withCountryCode = (bool)$options['withCountryCode'];
        }
        if (isset($options['hyphenRequired'])) {
            $this->hyphenRequired = (bool)$options['hyphenRequired'];
        }
        if (isset($options['hyphenIgnored'])) {
            $this->hyphenIgnored = (bool)$options['hyphenIgnored'];
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
        $prefix = $this->withCountryCode
            ? '(\+\d{1,4})'
            : '0';

        $hyphen = '-?';
        if ($this->hyphenRequired) {
            $hyphen = '-';
        } else if ($this->hyphenIgnored) {
            $hyphen = '';
        }

        return preg_match('/^' . $prefix . '[1-9]\d{0,3}' . $hyphen . '\d{1,4}' . $hyphen . '\d{3,4}$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('laravel-utilities::validation.phone_number');
    }
}
