<?php

declare(strict_types=1);

namespace TypistTech\Imposter;

class ConfigFactory
{
    public static function build(string $path, Filesystem $filesystem): Config
    {
        return new Config(
            $filesystem->dirname($path),
            json_decode(
                $filesystem->get($path),
                true
            )
        );
    }

    public static function buildProjectConfig(string $path, Filesystem $filesystem): ProjectConfig
    {
        return new ProjectConfig(
            $filesystem->dirname($path),
            json_decode(
                $filesystem->get($path),
                true
            )
        );
    }
}
