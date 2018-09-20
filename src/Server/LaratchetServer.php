<?php

namespace SysMl\Laratchet\Server;

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\Wamp\WampServer;
use Ratchet\WebSocket\WsServer;
use React\EventLoop\Factory;
use React\Socket\Server;
use React\ZMQ\Context;


class LaratchetServer{


    /**
     * Start the server
     * @Source: http://socketo.me/docs/push (Modified for Laravel)
     * @throws \React\Socket\ConnectionException
     */
    public function serve()
    {
        $loop   = Factory::create();
        $pusher = new Pusher();

        // Listen for the web server to make a ZeroMQ push after an ajax request
        $context = new Context($loop);
        $pull = $context->getSocket(\ZMQ::SOCKET_PULL);
        $pull->bind(\Config::get('laratchet.pullServer')); // Binding to 127.0.0.1 means the only client that can connect is itself

        $pull->on('message', [$pusher, 'onPush']);

        // Set up our WebSocket server for clients wanting real-time updates
        $webSock = new Server($loop);
        $webSock->listen(\Config::get('laratchet.pushServerPort'), \Config::get('laratchet.pushServer')); // Binding to 0.0.0.0 means remotes can connect
        $webServer = new IoServer(
            new HttpServer(
                new WsServer(
                    new WampServer(
                        $pusher
                    )
                )
            ),
            $webSock
        );

        $loop->run();
    }
}

