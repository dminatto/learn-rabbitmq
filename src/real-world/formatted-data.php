<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

//create a connection with the server
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');

$channel = $connection->channel();

//declare or/and create queue
$channel->queue_declare('dados_formatados', false, false, false, false);

echo " [*] Esperando por dados formatados.\n";

$callback = function ($msg) {
    echo ' [x] Dados formatados: ', $msg->body, "\n";
};

//consume the queue defined
$channel->basic_consume('dados_formatados', '', false, true, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();

