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

final class ImposterFactory
{
    private function __construct()
    {
    }

    /**
     * @param string   $projectPath
     * @param string[] $extraExcludes
     *
     * @return Imposter
     */
    public static function forProject(string $projectPath, array $extraExcludes = []): Imposter
    {
        $filesystem = new Filesystem;

        $projectConfig = ConfigFactory::buildProjectConfig($projectPath . '/composer.json', $filesystem);
        $projectConfig->setExtraExcludes($extraExcludes);

        $transformer      = new Transformer($projectConfig->getImposterNamespace(), $filesystem);
        $configCollection = ConfigCollectionFactory::forProject(
            $projectConfig,
            $filesystem
        );

        return new Imposter($configCollection, $transformer);
    }
}
