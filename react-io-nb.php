<?php

use React\EventLoop\Loop;
use React\Stream\DuplexResourceStream;
use React\Stream\ReadableResourceStream;

require_once 'vendor/autoload.php';

$loop = Loop::get();

$streamList = [
    new ReadableResourceStream(stream_socket_client('tcp://localhost:8081'), $loop),
    new ReadableResourceStream(fopen('arquivo1.txt', 'r'), $loop),
    new ReadableResourceStream(fopen('arquivo2.txt', 'r'), $loop),
];

$http = new DuplexResourceStream(stream_socket_client('tcp://localhost:8080'), $loop);
$http->write('GET /http-server.php HTTP 1.1'.PHP_EOL.PHP_EOL);
$http->on('data', static function (string $data){
    $posicaoFimHttp = strpos($data, "\r\n\r\n");
    echo substr($data, $posicaoFimHttp + 4), PHP_EOL;
});

foreach ($streamList as $stream) {
    $stream->on('data', static function (string $data) {
        echo $data, PHP_EOL;
    });
}

$loop->run();
