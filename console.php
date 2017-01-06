<?php
    require('vendor/autoload.php');
    use LFW\Console\Command;

    if(count($argv) == 1 || $argv[1] == 'console:listcommand'){
        require_once('vendor/LFW/Console/listcommand.php');

        foreach($array as $k => $v){
            echo $k.' => '.$v.PHP_EOL;
        }
    }
    else{
        $cmd = new Command($argv);
        $cmd->work();
    }