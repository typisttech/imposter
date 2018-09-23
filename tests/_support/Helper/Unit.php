<?php

namespace TypistTech\Imposter\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Codeception\Module;
use Codeception\TestInterface;
use Mockery;

class Unit extends Module
{
    public function _after(TestInterface $test)
    {
        $this->getModule('Filesystem')->deleteDir(codecept_data_dir('tmp-vendor'));
        Mockery::close();
    }

    public function _before(TestInterface $test)
    {
        $this->getModule('Filesystem')->copyDir(codecept_data_dir('fake-vendor'), codecept_data_dir('tmp-vendor'));
    }
}
