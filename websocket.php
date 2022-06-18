<?php

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

require_once 'vendor/autoload.php';

$chatComponent = new ChatComponent();

$server = IoServer::factory(
    new HttpServer(
        new WsServer($chatComponent)
    ),
    '8002'
);

$server->run();
