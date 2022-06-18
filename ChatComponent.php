<?php

use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\MessageComponentInterface;

require_once 'vendor/autoload.php';

class ChatComponent implements MessageComponentInterface
{
    private SplObjectStorage $connections;

    public function __construct()
    {
        $this->connections = new SplObjectStorage();
    }

    public function onOpen(ConnectionInterface $conn): void
    {
        echo "Nova conexão aceita", PHP_EOL;
        $this->connections->attach($conn);
    }

    public function onClose(ConnectionInterface $conn): void
    {
        $this->connections->detach($conn);
    }

    public function onError(ConnectionInterface $conn, Exception $e): void
    {
        echo 'Erro: ' > $e->getTraceAsString();
    }

    public function onMessage(ConnectionInterface $from, MessageInterface $msg): void
    {
        foreach ($this->connections as $connection) {
            if ($connection !== $from) {
                $connection->send((string) $msg);
            }
        }
    }
}
