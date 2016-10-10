<?php
    namespace LFW\Console\Bundle;

    /**
     * Class GenerateController
     * @package LFW\Console\Bundle
     */
    class GenerateController{
        /**
         * GenerateController constructor.
         * @param string $name
         * @param string $bundle
         * @param bool $action
         */
        public function __construct($name, $bundle, $action = false){
            $list = explode('/', $action);

            $code = "<?php\n";
            $code .= '	namespace Bundles\\'.$bundle.'\\Controllers;'."\n\n";
            $code .= '	class '.ucfirst($name).'{'."\n";
            foreach($list as $l){
                $code .= '		public function '.$l.'(){'."\n";
                $code .= '			'."\n";
                $code .= '		}'."\n\n";
            }

            $code .= '	}';

            file_put_contents('Bundles/'.$bundle.'/Controllers/'.ucfirst($name).'.php', $code);

            echo 'Le controller '.ucfirst($name).' a bien été créé.'.PHP_EOL;
        }
    }