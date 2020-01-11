<?php

declare(strict_types=1);

namespace TypistTech\Imposter;

class StringUtil
{
    public static function addTrailingSlash(string $string): string
    {
        return rtrim($string, '/\\') . '/';
    }

    public static function ensureDoubleBackwardSlash(string $string): string
    {
        $parts = explode('\\', $string);
        $nonEmptyParts = array_filter($parts, function ($part) {
            return ! empty($part);
        });

        return implode('\\\\', $nonEmptyParts) . '\\\\';
    }
}
