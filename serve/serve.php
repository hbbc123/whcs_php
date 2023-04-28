<?php
    // require __DIR__ . '/../vendor/autoload.php';
  

//   $s=new app\index\controller\Index;

//监听WebSocket连接打开事件


$ws = new Swoole\WebSocket\Server('0.0.0.0', 250);
$ws->on('Open', function ($ws, $request) {
    require __DIR__ . '/../public/index.php';
    define('APP_PATH', __DIR__ . '/../app/');
    $s=new app\index\controller\Index;
    var_dump($s->index());
    $ws->push($request->fd, "hello, welcome\n");
});

//监听WebSocket消息事件
$ws->on('Message', function ($ws, $frame) {
    echo "Message: {$frame->data}\n";
 
    $ws->push($frame->fd, "server: {$frame->data}");
});

//监听WebSocket连接关闭事件
$ws->on('Close', function ($ws, $fd) {
    echo "client-{$fd} is closed\n";
});

$ws->start();
