<?php

declare(strict_types = 1);

namespace TypistTech\Imposter;

class ArrayUtil
{
    private function __construct()
    {
    }

    public static function flattenMap(callable $callable, array $array): array
    {
        $map = array_map($callable, $array);

        return ArrayUtil::flatten($map);
    }

    public static function flatten(array $array): array
    {
        return call_user_func_array('array_merge', $array);
    }
}
