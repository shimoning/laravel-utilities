<?php

namespace Shimoning\LaravelUtilities\Rules;

use Illuminate\Contracts\Validation\Rule;

class PostalCode implements Rule
{
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
        $hyphen = '-?';
        if ($this->hyphenRequired) {
            $hyphen = '-';
        } else if ($this->hyphenIgnored) {
            $hyphen = '';
        }

        return preg_match('/^\d{3}' . $hyphen . '\d{4}$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('laravel-utilities::validation.postal_code');
    }
}
