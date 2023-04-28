<?php
declare (strict_types = 1);

namespace app\enter\controller;

use app\Swoole\WebSocket\Server;
class Index
{
    public function index()
    {
        return json(789);
    }
}
