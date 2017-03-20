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

final class StringUtil
{
    private function __construct()
    {
    }

    public static function addDoubleTrailingBackwardSlash(string $string): string
    {
        return rtrim($string, '/\\') . '\\\\';
    }

    public static function addTrailingSlash(string $string): string
    {
        return rtrim($string, '/\\') . '/';
    }
}
