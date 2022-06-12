<?php

use GuzzleHttp\Client;
use GuzzleHttp\Promise\Utils;

require_once 'vendor/autoload.php';

$client = new Client();

// Forma sequencial
// $resposta1 = $client->get('http://localhost:8080/http-server.php');
// $resposta2 = $client->get('http://localhost:8000/http-server.php');

// echo 'Resposta 1: ' . $resposta1->getBody()->getContents();
// echo 'Resposta 2: ' . $resposta2->getBody()->getContents();

$promessa1 = $client->getAsync('http://localhost:8080/http-server.php');
$promessa2 = $client->getAsync('http://localhost:8000/http-server.php');

$respostas = Utils::unwrap([
    $promessa1,
    $promessa2,
]);

echo 'Resposta 1: '.$respostas[0]->getBody()->getContents();
echo 'Resposta 2: '.$respostas[1]->getBody()->getContents();
