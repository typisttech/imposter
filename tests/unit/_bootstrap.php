<?php
// Here you can initialize variables that will be available to your tests

$kernel = \AspectMock\Kernel::getInstance();
$kernel->init([
    'debug'        => true,
    'includePaths' => [codecept_root_dir('src')],
]);
