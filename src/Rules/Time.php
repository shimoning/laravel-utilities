<?php

namespace Shimoning\LaravelUtilities\Rules;

use Illuminate\Contracts\Validation\Rule;

class Time implements Rule
{
    /**
     * 24時間を超える時間フォーマットを許容するかどうか
     *
     * @var bool
     */
    public $allowOver24 = false;

    /**
     * 秒を必須とする
     *
     * @var bool
     */
    public $secondRequired = false;

    /**
     * 秒を禁止する
     *
     * @var bool
     */
    public $secondIgnored = false;

    /**
     * @param array|null
     * @return void
     */
    public function __construct($options = null)
    {
        if (isset($options['allowOver24'])) {
            $this->allowOver24 = (bool)$options['allowOver24'];
        }
        if (isset($options['secondRequired'])) {
            $this->secondRequired = (bool)$options['secondRequired'];
        }
        if (isset($options['secondIgnored'])) {
            $this->secondIgnored = (bool)$options['secondIgnored'];
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
        $hour = $this->allowOver24
            ? '(\d+):'
            : '([01]?[0-9]|2[0-3]):';

        $second = '(:[0-5]?[0-9])?';
        if ($this->secondRequired) {
            $second = ':([0-5]?[0-9])';
        } else if ($this->secondIgnored) {
            $second = '';
        }

        return preg_match('/\A' . $hour . '([0-5]?[0-9])' . $second . '\z/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->allowOver24
            ? trans('laravel-utilities::validation.time_over_24')
            : trans('laravel-utilities::validation.time');
    }
}
