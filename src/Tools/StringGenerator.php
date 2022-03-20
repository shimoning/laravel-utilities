<?php

namespace Shimoning\LaravelUtilities\Tools;

use Hashids\Hashids;

class StringGenerator
{
    /**
     * ぱっと見混同しやすい文字を抜いた
     * 1, i, l, I
     * 2, z, Z
     * 6, b
     * 9, g, q
     * 0, o, O
     * u, v
     */
    const SAFER_CHARACTERS = '34578acdefhjkmnprstwxyABCDEFGHJKLMNPQRSTUVWXY';

    /**
     * 重複なしのランダム文字列を生成する
     *
     * @param integer $length
     * @return string
     */
    public static function getRandomString (int $length = 8): string
    {
        return \substr(\str_shuffle(self::SAFER_CHARACTERS), 0, $length);
    }

    /**
     * 数値ユニーク文字列を生成する
     *
     * @param integer $number
     * @param integer $length
     * @return string
     */
    public static function getUniqueString (int $number, int $length = 8): string
    {
        return (new Hashids(config('app.key'), $length, self::SAFER_CHARACTERS))->encode($number);
    }
}
