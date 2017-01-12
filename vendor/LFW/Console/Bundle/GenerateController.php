<?php
    namespace LFW\Console\Bundle;
    use LFW\Console\CommandInterface;
    use LFW\Framework\FileSystem\File;

    /**
     * Class GenerateController
     * @package LFW\Console\Bundle
     */
    class GenerateController implements CommandInterface{
        /**
         * GenerateController constructor.
         * @param array $argv
         */
        public function __construct(array $argv){}

        public function work(){
            fwrite(STDOUT, 'Nom du controller : ');
            $name = (string) trim(fgets(STDIN));

            fwrite(STDOUT, 'Nom du bundle : ');
            $bundle = (string) trim(fgets(STDIN));

            fwrite(STDOUT, 'Des actions ? (Séparez les noms par /) ');
            $action = (string) trim(fgets(STDIN));

            $list = explode('/', $action);

            $code = "<?php\n";
            $code .= '	namespace Bundles\\'.$bundle.'\\Controllers;'."\n";
            $code .= '  use LFW\\Framework\\DIC\\Dic;'."\n\n";
            $code .= '	class '.ucfirst($name).'{'."\n";
            $code .= '      public function __construct(Dic $dic){'."\n";
            $code .= '          '."\n";
            $code .= '      }'."\n\n";

            foreach($list as $l){
                $code .= '		public function '.$l.'(){'."\n";
                $code .= '			'."\n";
                $code .= '		}'."\n\n";
            }

            $code .= '	}';

            File::create('Bundles/'.$bundle.'/Controllers/'.ucfirst($name).'.php', $code);
            echo 'Le controller '.ucfirst($name).' a bien été créé.'.PHP_EOL;
        }
    }