<?php

namespace MyPlugin\Vendor\Dummy\File;

use MyPlugin\Vendor\AnotherDummy\{
    SubAnotherDummy, SubOtherDummy
};
use Composer;
use Composer\Plugin\PluginInterface;
use MyPlugin\Vendor\Dummy\SubOtherDummy;
use MyPlugin\Vendor\OtherDummy\SubOtherDummy;
use RuntimeException;
use \UnexpectedValueException;
use function MyPlugin\Vendor\OtherVendor\myFunc;
use const MyPlugin\Vendor\OtherVendor\MY_MAGIC_NUMBER;
use MyPlugin\Vendor\OtherVendor\MyTrait;
use MyPlugin\Vendor\OtherVendor\Package;

namespace MyPlugin\Vendor\OtherVendor\Package2 {
    use MyPlugin\Vendor\OtherVendor\MyTrait;

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
