<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');

$channel = $connection->channel();

$channel->queue_declare('dados_cliente', false, false, false, false);

//receive  data
$payload = [
    'id' => 1,
    'nome' => 'Maria',
    'sobrenome' => 'da Silva',
    'cpf' => '03674982155',
];

$msg = new AMQPMessage(json_encode($payload));

$channel->basic_publish($msg, '', 'dados_cliente');

echo " [x] Mensagem enviada'\n";

$channel->close();

$connection->close();

