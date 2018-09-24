<?php

namespace Dummy\File;

use AnotherDummy\{
    SubAnotherDummy, SubOtherDummy
};
use Composer;
use Composer\Plugin\PluginInterface;
use Dummy\SubOtherDummy;
use OtherDummy\SubOtherDummy;
use RuntimeException;
use \UnexpectedValueException;
use function OtherVendor\myFunc;
use const OtherVendor\MY_MAGIC_NUMBER;

$closure = function () use ($aaa) {
    // Just testing.
};

class DummyClass
{
    public function useClosure()
    {
        array_map(function () use ($xxx) {
            // Just testing.
        }, []);
    }
}
