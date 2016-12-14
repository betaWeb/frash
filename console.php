<?php
    require('vendor/autoload.php');
    use LFW\Console\Bundle\{ GenerateBundle, GenerateController };
    use LFW\Console\Files\ClearCache;
    use LFW\Console\ORM\{ Addentity, Createdb };
    use LFW\DocGen\{ GenerationDoc, ListDirFiles, TreatmentClass, TreatmentList };

    if(count($argv) == 1 || $argv[1] == 'console:listcommand'){
        require_once('vendor/LFW/Console/listcommand.php');

        foreach($array as $k => $v){
            echo $k.' => '.$v.PHP_EOL;
        }
    }
    else{
        $expl = explode(':', $argv[1]);

        if($argv[1] == 'Clear:Cache'){
            $cc = new ClearCache();
            $cc->work('vendor/LFW/Cache/Templating');
        }
        elseif($argv[1] == 'ORM:createdb' && !empty($argv[2])){
            new Createdb($argv[2]);
        }
        elseif($expl[0] == 'ORM' && $expl[1] == 'addentity' && !empty($expl[2]) && !empty($expl[3]) && !empty($argv[2])){
            new Addentity($expl[2], $expl[3], $argv[2]);
        }
        elseif($expl[0] == 'Bundle' && $expl[1] == 'generate' && !empty($expl[2])){
            new GenerateBundle($expl[2]);
        }
        elseif($argv[1] == 'Controller:generate'){
            fwrite(STDOUT, 'Nom du controller : ');
            $name = trim(fgets(STDIN));

            fwrite(STDOUT, 'Nom du bundle : ');
            $bundle = trim(fgets(STDIN));

            fwrite(STDOUT, 'Des actions ? (Séparez les noms par /) ');
            $action = trim(fgets(STDIN));

            new GenerateController($name, $bundle, $action);
        }
        elseif($argv[1] == 'Documentation:create'){
            fwrite(STDOUT, 'Dossier de sortie : ');
            $output = trim(fgets(STDIN));

            fwrite(STDOUT, 'Exceptions (Séparez par ;) : ');
            $except = trim(fgets(STDIN));

            $list = ListDirFiles::generation(getcwd());
            TreatmentList::setExcept($except);
            $new_list = TreatmentList::removeExcept($list);

            TreatmentClass::generationClass($new_list);
            GenerationDoc::work($output, TreatmentClass::getClass());
        }
    }