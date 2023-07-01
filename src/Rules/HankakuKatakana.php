<?php

namespace Shimoning\LaravelUtilities\Rules;

use Illuminate\Contracts\Validation\Rule;

class HankakuKatakana implements Rule
{
    const HANKAKU_KATAKANA = 'ｦ-ﾟ';
    const HANKAKU_KIGOU = '｡｢｣､･';
    const ALPHABET = 'A-Za-z';
    const NUMBER = '0-9';
    const SYMBOL = '!-\/:-@\[-`\{-\~';

    /**
     * 半角記号(日本語)を受け付ける
     *
     * @var bool
     */
    public $withKigou = false;

    /**
     * 半角英字を受け付ける
     *
     * @var bool
     */
    public $withAlphabet = false;

    /**
     * 半角数字を受け付ける
     *
     * @var bool
     */
    public $withNumber = false;

    /**
     * 半角記号(ASCII)を受け付ける
     *
     * @var bool
     */
    public $withSymbol = false;

    /**
     * 半角スペースを受け付ける
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
        if (isset($options['withKigou'])) {
            $this->withKigou = (bool)$options['withKigou'];
        }
        if (isset($options['withAlphabet'])) {
            $this->withAlphabet = (bool)$options['withAlphabet'];
        }
        if (isset($options['withNumber'])) {
            $this->withNumber = (bool)$options['withNumber'];
        }
        if (isset($options['withSymbol'])) {
            $this->withSymbol = (bool)$options['withSymbol'];
        }
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
        $regex = self::HANKAKU_KATAKANA
            . ($this->withKigou ? self::HANKAKU_KIGOU : '')
            . ($this->withAlphabet ? self::ALPHABET : '')
            . ($this->withNumber ? self::NUMBER : '')
            . ($this->withSymbol ? self::SYMBOL : '')
            . ($this->withSpace ? ' ' : '');

        return preg_match(
            '/\A[' . $regex . ']+' . ($this->allowMultiline ? '\Z' : '\z') . '/u',
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
        return trans('laravel-utilities::validation.hankaku-katakana');
    }
}
