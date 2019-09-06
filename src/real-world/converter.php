<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

//create a connection with the server
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');

$channel = $connection->channel();

//declare or/and create queue
$channel->queue_declare('dados_cliente', false, false, false, false);

echo " [*] Esperando por mensagens. To exit press CTRL+C\n";

$callback = function ($msg) use ($channel){
    echo ' [x] Dados recebidos: ', $msg->body, "\n";

    $dadosRecebidos = json_decode($msg->body);

    $novoCPF  = substr( $dadosRecebidos->cpf, 0, 3 ) . '.';
    $novoCPF .= substr( $dadosRecebidos->cpf, 3, 3 ) . '.';
    $novoCPF .= substr( $dadosRecebidos->cpf, 6, 3 ) . '-';
    $novoCPF .= substr( $dadosRecebidos->cpf, 9, 2 ) . '';

    $dadosConvertidos = [
        'novoId' => $dadosRecebidos->id,
        'nomeCompleto' => $dadosRecebidos->nome . ' ' . $dadosRecebidos->sobrenome,
        'cpfFormatado' => $novoCPF,
        'ativo' => 0,
    ];

    $channel->queue_declare('dados_formatados', false, false, false, false);
    $msg = new AMQPMessage(json_encode($dadosConvertidos));

    $channel->basic_publish($msg, '', 'dados_formatados');

    echo " [x] Mensagem enviada'\n";

};

//consume the queue defined
$channel->basic_consume('dados_cliente', '', false, true, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();

