<?php
    require('vendor/autoload.php');
    use LFW\Console\Command;
    use LFW\Framework\Request\Server\Console;

    if(count($argv) == 1 || $argv[1] == 'console:listcommand'){
        require_once('vendor/LFW/Console/listcommand.php');

        foreach($array as $k => $v){
            echo $k.' => '.$v.PHP_EOL;
        }
    }
    else{
        $cmd = new Command(Console::argv());
        $cmd->work();
    }