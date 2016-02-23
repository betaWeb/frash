<?php
    session_start();
    require_once('vendor/autoload.php');
    use Composants\Framework\Routing\Router;

    new Router(ltrim($_SERVER['REQUEST_URI'], '/'));