<?php
namespace Flexachiller\WebsocketChat;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

require dirname(__DIR__) . "/database/ChatUser.php";
require dirname(__DIR__) . "/database/ChatRooms.php";

class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        echo 'Server Started';
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages later
        echo 'Server Started';
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');
            foreach ($this->clients as $client) 
            {
                if ($from !== $client) 
                {
                    // The sender is not the receiver, send to each client connected
                    $client->send($msg);
                }
            }
    }

    public function onClose(ConnectionInterface $conn) {
        
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
       
    }
}