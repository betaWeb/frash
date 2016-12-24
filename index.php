<?php
    session_start();
    require_once('vendor/autoload.php');
    use LFW\Framework\DIC\Dic;
    use LFW\Framework\Globals\Server;
    use LFW\Framework\Routing\Prefix;

    $dic = new Dic();

    $gets = $dic->load('get');
    $gets->set('time_warning', time());
    $gets->set('prefix', Prefix::define(Server::getScriptName()));

    $dic->load('microtime')->setMicrotime('start');
    $dic->load('router')->routing(ltrim(Server::getRequestUri(), $gets->get('prefix')));