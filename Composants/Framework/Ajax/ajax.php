<?php
    error_reporting(E_ALL);
    header('Access-Control-Allow-Origin: *');
    header('Content-type: application:json');

    require('../../../vendor/autoload.php');
    use Composants\Yaml\Yaml;

    $routing = Yaml::parse(file_get_contents('../../../Composants/Configuration/routing_ajax.yml'));

    if(isset($routing[ $_POST['route'] ])){
        $path = 'Composants\\Framework\\Ajax\\AjaxClass\\'.$routing[ $_POST['route'] ];
        $class = new $path(json_decode($_POST['params']));

        echo(json_encode($class->getReturn()));
    }