<?php
    session_start();
    require_once('vendor/autoload.php');
    use Composants\Framework\DIC\Dic;
    use Composants\Framework\Globals\Server;

    $dic = new Dic();
    $dic->load('router')->routing(ltrim(Server::getRequestUri(), '/'), $dic);