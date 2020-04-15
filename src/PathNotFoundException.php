<?php

namespace TypistTech\Imposter;

use Throwable;

class PathNotFoundException extends \Exception
{
    protected $path;

    public function __construct($path, Throwable $previous = null)
    {
        $this->path = $path;

        parent::__construct("Path \"{$path}\" not found", $previous ? $previous->getCode() : 0, $previous);
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}
