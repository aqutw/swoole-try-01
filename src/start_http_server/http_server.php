<?php
$http = new Swoole\Http\Server('0.0.0.0', 9501);

$http->on('request', function ($request, $response) {
  if ($request->server['path_info'] == '/favicon.ico' || $request->server['request_uri'] == '/favicon.ico') {
      if(isset($request->get['debug'])){
        var_dump('-favicon.ico here-');
      }
      $response->end();
      return;
  }
  if(isset($request->get['debug'])){
    echo'server...';
    var_dump($request->server);
    echo'get...';
    var_dump($request->get);
    echo'post...';
    var_dump($request->post);
  }
  $response->header("Content-Type", "text/html; charset=utf-8");
  $response->end("<h1>Hello Swoole. #".rand(1000, 9999)."</h1>");
});

$http->start();