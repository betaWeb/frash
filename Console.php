<?php
    require('vendor/autoload.php');
    use Console\ORM\Createdb;
    use Console\ORM\Addentity;
    use Console\ORM\Updentity;
    use Console\Bundle\GenerateBundle;

    function read_stdin(){
        $st = fopen('php://stdin', 'r');
        $input = fgets($st, 200);
        $input = rtrim($input);
        fclose($st);

        return $input;
    }

    if(count($argv) == 1){
        echo 'Aucun paramètre'.PHP_EOL;
        exit();
    }

    $expl = explode(':', $argv[1]);

    if($expl[0] == 'ORM' && $expl[1] == 'createdb'){
        new Createdb();
    }

    if($expl[0] == 'ORM' && $expl[1] == 'addentity' && !empty($expl[2]) && !empty($argv[2])){
        new Addentity($expl[2], $argv[2]);
    }

    if($expl[0] == 'ORM' && $expl[1] == 'updentity' && !empty($expl[2])){
        new Updentity($expl[2]);
    }

    if($expl[0] == 'Bundle' && $expl[1] == 'generate' && !empty($expl[2])){
        new GenerateBundle($expl[2]);
    }

    if($expl[0] == 'console' && $expl[1] == 'listcommand'){
        require_once('Console/listcommand.php');

        foreach($array as $k => $v){
            echo $k.' => '.$v.PHP_EOL;
        }
    }