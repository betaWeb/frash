<?php
    namespace Composants\Console\ORM;

    class Addjoin{
        public function __construct($bundle, $name, $champ){
            $champs = explode('/', $champ);
            $list = [];

            foreach($champs as $c){
                $list[] = $c;
            }

            $code = "<?php\n";
            $code .= '	namespace Bundles\\'.$bundle.'\\Entity\Jointure;'."\n\n";
            $code .= '	class '.ucfirst($name).'{'."\n";
            foreach($list as $l){
                $code .= '		protected $'.$l.';'."\n";
            }

            foreach($list as $l2){
                $code .= "		\n";
                $code .= '		public function get'.ucfirst($l2).'(){'."\n";
                $code .= '			return $this->'.$l2.';'."\n";
                $code .= '		}'."\n\n";

                $code .= '		public function set'.ucfirst($l2).'($'.$l2.'){'."\n";
                $code .= '			$this->'.$l2.' = $'.$l2.';'."\n";
                $code .= '		}'."\n";
            }
            $code .= '	}';

            file_put_contents('Bundles/'.$bundle.'/Entity/Jointure/'.ucfirst($name).'.php', $code);

            echo 'L\'entité '.ucfirst($name).' a bien été créée.'.PHP_EOL;
        }
    }