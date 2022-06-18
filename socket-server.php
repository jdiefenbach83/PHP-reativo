<?php

$socket = stream_socket_server('tcp://localhost:8081');

$con = stream_socket_accept($socket);

$espera = rand(1, 5);
sleep($espera);
fwrite($con, "Resposta do socket após {$espera} segundos".PHP_EOL);

fclose($con);
