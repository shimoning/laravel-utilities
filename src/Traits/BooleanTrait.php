<?php

namespace Shimoning\LaravelUtilities\Traits;

trait BooleanTrait
{
    /**
     * 真偽値に変換する
     *
     * - 1 / 0
     * - '1' / '0'
     * - true / false
     * - 'true' / 'false'
     * - on / 'off'
     * - yes / 'no'
     *
     * それ以外は null
     *
     * @param mixed $value
     * @return bool|null
     */
    public function toBoolean($value): ?bool
    {
        return \filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }
}

