<?php

use Psr\Http\Message\ResponseInterface;
use React\EventLoop\Loop;
use React\Http\Browser;
use React\Stream\ReadableResourceStream;

require_once 'vendor/autoload.php';

$loop = Loop::get();

$streamList = [
    new ReadableResourceStream(stream_socket_client('tcp://localhost:8081'), $loop),
    new ReadableResourceStream(fopen('arquivo1.txt', 'r'), $loop),
    new ReadableResourceStream(fopen('arquivo2.txt', 'r'), $loop),
];

$http = new Browser(null, $loop);
$http->get('http://localhost:8080/http-server.php')
    ->then(
        static function (ResponseInterface $response) {
            echo $response->getBody();
        }
    )
;

foreach ($streamList as $stream) {
    $stream->on('data', static function (string $data) {
        echo $data, PHP_EOL;
    });
}

$loop->run();
