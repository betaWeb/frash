<?php
    session_start();
    require_once('vendor/autoload.php');

    use LFW\Framework\ExtensionLoaded;
    use LFW\Framework\DIC\Dic;
    use LFW\Framework\Globals\Server\Server;
    use LFW\Framework\Routing\Prefix;

    $dic = new Dic();
    $dic->load('microtime')->set('start');
    $dic->set('prefix', Prefix::define(Server::getScriptName()));
    $dic->set('memcached', ExtensionLoaded::memcached());

    if($dic->get('memcached') === true){
    	$dic->load('memcached')->server();
    }

    $dic->load('route')->routing(substr(Server::getRequestUri(), strlen($dic->get('prefix'))));