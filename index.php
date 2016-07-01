<?php
    session_start();
    require_once('vendor/autoload.php');
    use Composants\Framework\Globals\Server;
    use Composants\Framework\Routing\Router;

    new Router(ltrim(Server::getRequestUri(), '/'));
    Router::routing();