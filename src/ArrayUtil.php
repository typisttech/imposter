<?php

declare(strict_types=1);

namespace TypistTech\Imposter;

class ArrayUtil
{
    public static function flattenMap(callable $callable, array $array): array
    {
        $map = array_map($callable, $array);

        return static::flatten($map);
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
        $result = [];
        foreach ($array as $item) {
            if (is_array($item)) {
                $result = array_merge($result, array_values($item));
            } else {
                $result[] = $item;
            }
        }
        return $result;
    }
}
