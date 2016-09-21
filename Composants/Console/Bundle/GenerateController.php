<?php
    namespace Composants\Console\Bundle;

    /**
     * Class GenerateController
     * @package Composants\Console\Bundle
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
            $code .= '	namespace Bundles\\'.$bundle.'\\Controllers;'."\n";
            $code .= '	use Composants\Framework\Controller;'."\n\n";
            $code .= '	class '.ucfirst($name).' extends Controller {'."\n";
            $code .= '		public function __construct(){'."\n";
            $code .= '			parent::__construct();'."\n";
            $code .= '		}'."\n\n";

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