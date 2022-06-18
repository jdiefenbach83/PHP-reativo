<?php

use \React\EventLoop\Loop;

require_once 'vendor/autoload.php';

// \React\EventLoop\Factory::create() is deprecated
$loop = Loop::get();

$loop->addPeriodicTimer(1, static function () {
    echo "1 segundo", PHP_EOL;
});

$loop->run();