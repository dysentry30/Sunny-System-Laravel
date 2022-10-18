<?php 

namespace App\Websockets\SocketHandlers;

use Exception;
use BeyondCode\LaravelWebSockets\Apps\App;
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\MessageComponentInterface;

class WebsocketHandler implements MessageComponentInterface {
    public $clients = [];
    function onOpen(ConnectionInterface $conn)
    {
        $socketId = sprintf('%d.%d', random_int(1, 1000000000), random_int(1, 1000000000));
        $conn->socketId = $socketId;
        $conn->app = new \stdClass(); 
        $conn->app->id = 'my_app';
        $conn->send(json_encode(["status"=>"Connection Established", "socketId" => $conn->socketId ]));
        array_push($this->clients, $conn);
        // $conn->app = App::findById(env("APP_KEY"));
    }
    
    function onClose(ConnectionInterface $conn)
    {
        $clients = collect($this->clients);
        $this->clients = $clients->where("socketId", "!=", $conn->socketId)->all();
    }

    function onError(ConnectionInterface $conn, Exception $e)
    {
        
    }

    function onMessage(ConnectionInterface $from, MessageInterface $msg)
    {
        // $body = collect(json_decode($msg->getPayload(), true));
        // $payload = $body->get("payload");
        // dump($body);
        // $id = $body->get("id");
        foreach($this->clients as $client) {
            if($client->socketId != $from->socketId) {
                $client->send($msg->getPayload());
            }
        }
        // $from->send(json_encode($msg->getPayload()));
    }
}

?>