<?php
$server = new Swoole\Server('127.0.0.1', 9501);

$server->on('connect', function ($server, $fd) {
  echo "Client: Connect.\n";
});

$server->on('receive', function ($server, $fd, $from_id, $data) {
  $server->send($fd, "Server: " . $data . ' for ['.$fd.']');
});

$server->on('close', function ($server, $fd) {
  echo "Client: Close from ".$fd.".\n";
});

$server->start(); 

