<?php
$ws = new Swoole\WebSocket\Server('0.0.0.0', 9502);

$ws->on('open', function ($ws, $request) {
  var_dump($request->fd, $request->server);
  $ws->push($request->fd, "hello, welcome\n");
});

$ws->on('message', function ($ws, $frame) {
  echo "Message: {$frame->data}\n";

  global $ws;
  foreach ($ws->connections as $fd) {
    // 需要先判断是否是正确的websocket连接，否则有可能会push失败
    if ($ws->isEstablished($fd)) {
        $ws->push($fd, $frame->data # $request->get['message']
            );
    }
  }
  #$ws->push($frame->fd, "server: {$frame->data}");
});

$ws->on('close', function ($ws, $fd) {
  echo "client-{$fd} is closed\n";
});

/*
$ws->on('request', function (Swoole\Http\Request $request, Swoole\Http\Response $response) {
  global $ws;
  ob_start();
  print_r($ws->connection_info($request->fd));
  $s = ob_get_contents();
  ob_end_flush();
  $response->end("onRequest here." . rand(1000, 9999) . $s);
}); // then open google-chrome, goto... http://127.0.0.1:9502/bar http://127.0.0.1:9502/foo http://127.0.0.1:9502/
*/
/*
$ws->on('request', function (Swoole\Http\Request $request, Swoole\Http\Response $response) {
  global $ws;
  
  foreach ($ws->connections as $fd) {
      // 需要先判断是否是正确的websocket连接，否则有可能会push失败
      if ($ws->isEstablished($fd)) {
          $ws->push($fd, $request->get['message']);
      }
  }
});*/

$ws->start();
