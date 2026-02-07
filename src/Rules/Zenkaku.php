<?php

namespace Shimoning\LaravelUtilities\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * JTCでよく使われるいわゆる「全角」の文字のみ許可する
 * 半角カタカナ、半角英数字、半角記号は許可しない
 *
 * TODO: 日本語以外の拒否は別途対応
 */
class Zenkaku implements Rule
{
    /**
     * 半角スペース全角スペースを受け付ける
     *
     * @var bool
     */
    public $withHalfSpace = false;

    /**
     * 改行を許可する
     *
     * @var bool
     */
    public $allowMultiline = false;

    /**
     * 文字数
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
     * @param array|null
     * @return void
     */
    public function __construct($options = null)
    {
        if (isset($options['withHalfSpace'])) {
            $this->withHalfSpace = (bool)$options['withHalfSpace'];
        }
        if (isset($options['allowMultiline'])) {
            $this->allowMultiline = (bool)$options['allowMultiline'];
        }

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
        //mb_strlen
        $isZenkaku = preg_match(
            '/\A([^\x01-\x7E\xA1-\xDF]' . ($this->withHalfSpace ? '|\s' : '') . ')+' . ($this->allowMultiline ? '\Z' : '\z') . '/u',
            $value
        );
        if (!$isZenkaku) {
            $this->customMessage = trans('laravel-utilities::validation.zenkaku');
            return false;
        }
        if ($this->length !== null && mb_strlen($value) !== $this->length) {
            $this->customMessage = trans('laravel-utilities::validation.zenkaku-length', ['length' => $this->length]);
            return false;
        }

        if ($this->min !== null && mb_strlen($value) < $this->min) {
            $this->customMessage = trans('laravel-utilities::validation.zenkaku-min', ['min' => $this->min]);
            return false;
        }

        if ($this->max !== null && mb_strlen($value) > $this->max) {
            $this->customMessage = trans('laravel-utilities::validation.zenkaku-max', ['max' => $this->max]);
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
        return $this->customMessage ?? trans('laravel-utilities::validation.zenkaku');
    }
}
