<?php

namespace MyPlugin\Vendor\Dummy\File;

use MyPlugin\Vendor\AnotherDummy\{
    SubAnotherDummy, SubOtherDummy
};
use Composer;
use Composer\Plugin\PluginInterface;
use MyPlugin\Vendor\Dummy\SubOtherDummy;
use MyPlugin\Vendor\OtherDummy\SubOtherDummy;
use MyPlugin\Vendor\TypistTech\Imposter\Plugin;
use RuntimeException;
use \UnexpectedValueException;

class DummyClass
{
}
