<?php

use Ds\Set;
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\MessageComponentInterface;

require_once 'vendor/autoload.php';

class ChatComponent implements MessageComponentInterface
{
    private Set $connections;

    public function __construct()
    {
        $this->connections = new Set();
    }

    public function onOpen(ConnectionInterface $conn): void
    {
        echo "Nova conexão aceita", PHP_EOL;
        $this->connections->add($conn);
    }

    public function onClose(ConnectionInterface $conn): void
    {
        $this->connections->remove($conn);
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
