<?php
/**
 * Imposter
 *
 * Wrapping all composer vendor packages inside your own namespace.
 * Intended for WordPress plugins.
 *
 * @package   TypistTech\Imposter
 * @author    Typist Tech <imposter@typist.tech>
 * @copyright 2017 Typist Tech
 * @license   MIT
 * @see       https://www.typist.tech/projects/imposter
 */

declare(strict_types=1);

namespace TypistTech\Imposter;

final class ArrayUtil
{
    private function __construct()
    {
    }

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
