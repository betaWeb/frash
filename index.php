<?php
    session_start();
    require_once('vendor/autoload.php');
    use LFW\Framework\DIC\Dic;
    use LFW\Framework\Globals\Server;

    $dic = new Dic();
    $dic->load('microtime')->setMicrotime('start');
    $dic->load('router')->routing(Server::getReqUriTrim());