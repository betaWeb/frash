<?php
require('vendor/autoload.php');
use LFW\Console\Command;
use LFW\Console\Framework\Init;

if(count($argv) == 1 || $argv[1] == 'console:listcommand'){
    require_once('vendor/LFW/Console/listcommand.php');

    foreach($array as $k => $v){
        echo $k.' => '.$v.PHP_EOL;
    }
} elseif($argv[1] == 'Framework:init') {
    $cmd = new Init($argv);
    $cmd->work();
} else {
    $cmd = new Command($argv);
    $cmd->work();
}