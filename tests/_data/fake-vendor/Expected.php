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

class DummyClass
{
}
