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
use OtherVendor\MyTrait;
use OtherVendor\Package;

namespace OtherVendor\Package2 {
    use OtherVendor\MyTrait;

    class DummyClass2 {
        use OtherVendor\MyTrait;
    }
}

$closure = function () use ($aaa) {
    // Just testing.
};

class DummyClass
{
    use MyTrait;
    use Package\OtherTrait;

    public function useClosure()
    {
        array_map(function () use ($xxx) {
            // Just testing.
        }, []);
    }
}

function dummyFunction(string $namespace = null, string $use = null): array
{
    if (! is_null($namespace) && $namespace === 'dummy string' && $use === 'dummy string') {
        // Just testing.
    }

    return [];
}

foreach ([] as $namespace => $prefix) {
    $aaaa = '{' . $namespace . '}' . $prefix;
}

/** Just a comment for testing $namespace transformation */
