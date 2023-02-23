<?php

namespace Shimoning\LaravelUtilities\Fakers;

class Product extends \Faker\Provider\Base
{
    public const GENRE_FOOD = 'food';
    public const GENRE_UNIT = 'unit';

    protected static $nouns = [
        '商品', 'アイテム', 'item', '製品',
    ];

    protected static $foods = [
        '青果品', '鮮魚', '精肉', '野菜', '果物', '米穀', '製麺', '卵',
        'パン', '菓子', '調味料', '飲料', '酒', '惣菜',
    ];

    protected static $units = [
        '本', '枚', '個', '袋', '缶', '箱',
        'セット', 'パック', '詰め合わせ', 'ダース', 'カートン'
    ];

    public function product($genre = null, $nbDigits = null)
    {
        if ($genre === static::GENRE_FOOD) {
            return static::food();
        }
        if ($genre === static::GENRE_UNIT) {
            return static::unit($nbDigits);
        }

        return static::randomElement(static::$nouns) . static::randomNumber($nbDigits);
    }

    public function food()
    {
        return static::randomElement(static::$foods);
    }

    public function unit($nbDigits = null)
    {
        return static::randomNumber($nbDigits) . static::randomElement(static::$units);
    }
}
