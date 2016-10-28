<?php
    namespace LFW\Console\ORM;

    /**
     * Class Addentity
     * @package LFW\Console\ORM
     */
    class Addentity{
        /**
         * Addentity constructor.
         * @param string $bundle
         * @param string $table
         * @param string $champ
         */
        public function __construct($bundle, $table, $champ){
            $champs = explode('/', $champ);
            $types = [];

            $code = "<?php\n";
            $code .= '	namespace Bundles\\'.$bundle.'\\Entity;'."\n\n";
            $code .= '	class '.ucfirst($table).'{'."\n";
            foreach($champs as $l){
                $name = '';
                $type = '';

                if(strstr($l, '=')){
                    $expl = explode('=', $l);
                    $name = $expl[0];
                    $type = $expl[1];
                }
                else{
                    $name = $l;
                }
                
                $types[ $name ] = (empty($type)) ? '' : $type;

                $code .= '		protected $'.$l.';'."\n";
            }

            foreach($champs as $l2){
                $code .= "		\n";
                $code .= '		public function get'.ucfirst($l2).'(){'."\n";
                $code .= '			return $this->'.$l2.';'."\n";
                $code .= '		}'."\n\n";
                $code .= '		public function set'.ucfirst($l2).'($'.$l2.'){'."\n";
                $code .= '			$this->'.$l2.' = $'.$l2.';'."\n";
                $code .= '		}'."\n";
            }
            $code .= '	}';

            file_put_contents('Bundles/'.$bundle.'/Entity/'.ucfirst($table).'.php', $code);
            file_put_contents('Bundles/'.$bundle.'/Entity/Mapping/'.ucfirst($table).'.json', json_encode($types));

            echo 'L\'entité '.ucfirst($table).' a bien été créée.'.PHP_EOL;
        }
    }