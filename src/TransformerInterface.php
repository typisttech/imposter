<?php

declare(strict_types=1);

namespace TypistTech\Imposter;

interface TransformerInterface
{
    /**
     * Transform a file or directory recursively.
     *
     * @param string $target Path to the target file or directory.
     *
     * @return void
     */
    public function transform(string $target);
}
