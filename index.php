<?php
    session_start();
    require_once('vendor/autoload.php');
    use Composants\Framework\Routing\Router;
    use Composants\Framework\Http\Http;

    $http = new Http;
    new Router(ltrim($http->getRequestUri(), '/'));