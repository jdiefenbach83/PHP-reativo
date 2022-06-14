<?php

$streamList = [
    fopen('arquivo1.txt', 'r'),
    fopen('arquivo2.txt', 'r'),
];

foreach ($streamList as $stream) {
    stream_set_blocking($stream, false);
}

// arquivo tá pronto para ler?
do {
    $copyReadStream = $streamList;
    $numeroDeStreams = stream_select($copyReadStream, $write, $except, 0, 200000);

    if (0 === $numeroDeStreams) {
        // processa qualquer coisa
        continue;
    }

    foreach ($copyReadStream as $key => $stream) {
        echo fgets($stream);
        unset($streamList[$key]);
    }
} while (!empty($streamList));

echo 'Li todos os arquivos'.PHP_EOL;
