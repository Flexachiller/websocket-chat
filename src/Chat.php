<?php
namespace Flexachiller\WebsocketChat;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        
    }

    public function onClose(ConnectionInterface $conn) {
        
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
       
    }
}