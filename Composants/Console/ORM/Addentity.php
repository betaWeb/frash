<?php
    namespace Composants\Console\ORM;
    use Composants\Framework\ORM\Orm;
    use Composants\Yaml\Yaml;

    /**
     * Class Addentity
     * @package Console\ORM
     */
    class Addentity{
        /**
         * Addentity constructor.
         * @param $bundle
         * @param $table
         * @param $champ
         */
        public function __construct($bundle, $table, $champ){
            $array = Yaml::parse(file_get_contents('Others/config/database.yml'));
            Orm::init($array['host'], $array['dbname'], $array['username'], $array['password']);

            $champs = explode('/', $champ);

            $code = "<?php\n";
            $code .= '	namespace Bundles\\'.$bundle.'\\Entity;'."\n\n";
            $code .= '	class '.ucfirst($table).'{'."\n";
            foreach($champs as $l){
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

            echo 'L\'entité '.ucfirst($table).' a bien été créée.'.PHP_EOL;
        }
    }