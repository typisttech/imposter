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

final class ConfigFactory
{
    private function __construct()
    {
    }

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
