<?php

declare(strict_types = 1);

namespace TypistTech\Imposter;

final class StringUtil
{
    private function __construct()
    {
    }

    public static function addTrailingSlash(string $string): string
    {
        return rtrim($string, '/\\') . '/';
    }
}
