<?php
declare(strict_types=1);

namespace TypistTech\Imposter;

class ArrayUtil
{
    public static function flattenMap(callable $callable, array $array): array
    {
        $map = array_map($callable, $array);

        return self::flatten($map);
    }

    /**
     * Flatten array by one level.
     *
     * @param array $array
     *
     * @return array
     */
    public static function flatten(array $array): array
    {
        return call_user_func_array('array_merge', $array);
    }
}
