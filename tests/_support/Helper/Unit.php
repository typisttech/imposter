<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use AspectMock\Test;

class Unit extends \Codeception\Module
{
    public function _before(\Codeception\TestInterface $test)
    {
        $this->getModule('Filesystem')->copyDir(codecept_data_dir('fake-vendor'), codecept_data_dir('tmp-vendor'));
    }

    public function _after(\Codeception\TestInterface $test)
    {
        $this->getModule('Filesystem')->deleteDir(codecept_data_dir('tmp-vendor'));
        Test::clean();
    }
}
