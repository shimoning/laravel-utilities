<?php

namespace Shimoning\LaravelUtilities\Rules;

use Illuminate\Contracts\Validation\Rule;

class Katakana implements Rule
{
    /**
     * 半角スペース全角スペースを受け付ける
     *
     * @var bool
     */
    public $withSpace = false;

    /**
     * 改行を許可する
     *
     * @var bool
     */
    public $allowMultiline = false;

    /**
     * @param array|null
     * @return void
     */
    public function __construct($options = null)
    {
        if (isset($options['withSpace'])) {
            $this->withSpace = (bool)$options['withSpace'];
        }
        if (isset($options['allowMultiline'])) {
            $this->allowMultiline = (bool)$options['allowMultiline'];
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
        return preg_match(
            '/\A[ァ-ヶー' . ($this->withSpace ? ' 　' : '') . ']+' . ($this->allowMultiline ? '\Z' : '\z') . '/u',
            $value
        );
        return preg_match('/^[ァ-ヶー' . ($this->withSpace ? ' 　' : '' ) . ']+$/u', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('laravel-utilities::validation.katakana');
    }
}
