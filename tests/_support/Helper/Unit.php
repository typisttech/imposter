<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Unit extends \Codeception\Module
{
    // HOOK: before test
    public function _before(\Codeception\TestInterface $test)
    {
         $this->getModule('Filesystem')->copyDir(codecept_data_dir('fake-vendor'), codecept_data_dir('tmp-vendor'));
    }

    // HOOK: after test
    public function _after(\Codeception\TestInterface $test)
    {
         $this->getModule('Filesystem')->deleteDir(codecept_data_dir('tmp-vendor'));
    }
}
