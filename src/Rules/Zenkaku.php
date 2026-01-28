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
            '/\A([^\x01-\x7E\xA1-\xDF]' . ($this->withHalfSpace ? '|\s' : '') . ')+' . ($this->allowMultiline ? '\Z' : '\z') . '/u',
            $value
        );
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('laravel-utilities::validation.zenkaku');
    }
}
