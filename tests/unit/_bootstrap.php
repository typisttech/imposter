<?php
// Here you can initialize variables that will be available to your tests

$kernel = \AspectMock\Kernel::getInstance();
$kernel->init([
    'debug'        => true,
    'cacheDir' => getenv('TMPDIR') . 'AspectMock/imposter',
    'includePaths' => [codecept_root_dir('src')],
]);
