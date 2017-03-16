<?php

declare(strict_types = 1);

namespace TypistTech\Imposter;

use Illuminate\Filesystem\Filesystem;

final class ConfigFactory
{
    private function __construct()
    {
    }

    public static function read(string $path, Filesystem $filesystem): Config
    {
        return new Config(
            $filesystem->dirname($path) . '/',
            json_decode(
                $filesystem->get($path),
                true
            )
        );
    }
}
