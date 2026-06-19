<?php

namespace Shimoning\LaravelUtilities\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * 文字のバイト数でのバリデーション
 */
class CharByte implements Rule
{
    /**
     * 文字数 (一致)
     * 文字数の指定がある場合は、min,maxは無視される
     * @var int|null
     */
    public $length = null;

    /**
     * 最小数
     * @var int|null
     */
    public $min = null;

    /**
     * 最大数
     * @var int|null
     */
    public $max = null;

    /**
     * エラーメッセージ
     *
     * @var string|null
     */
    protected $customMessage = null;

    /**
     * @param array $options
     * @return void
     */
    public function __construct($options)
    {
        if (isset($options['length'])) {
            $this->length = (int)$options['length'];
        } else {
            if (isset($options['min'])) {
                $this->min = (int)$options['min'];
            }
            if (isset($options['max'])) {
                $this->max = (int)$options['max'];
            }
        }

        // どれか必須
        if ($this->length === null && $this->min === null && $this->max === null) {
            throw new \InvalidArgumentException('CharByte rule requires at least one of length, min, or max to be specified.');
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
        $length = strlen((string)$value);
        if ($this->length !== null && $length !== $this->length) {
            $this->customMessage = trans('laravel-utilities::validation.charbyte-length', ['length' => $this->length]);
            return false;
        }

        if ($this->min !== null && $length < $this->min) {
            $this->customMessage = trans('laravel-utilities::validation.charbyte-min', ['min' => $this->min]);
            return false;
        }

        if ($this->max !== null && $length > $this->max) {
            $this->customMessage = trans('laravel-utilities::validation.charbyte-max', ['max' => $this->max]);
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->customMessage ?? trans('laravel-utilities::validation.charbyte');
    }
}
