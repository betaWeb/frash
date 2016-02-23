<?php
    namespace Console\ORM;
    use Composants\ORM\Orm;
    use Composants\Yaml\Yaml;

    /**
     * Class Updentity
     * @package Console\ORM
     */
    class Updentity{
        /**
         * Updentity constructor.
         * @param $table
         * @param $bundle
         */
        public function __construct($table, $bundle){
            $array = Yaml::parse(file_get_contents('Others/config/config.yml'));
            Orm::init($array['database']['host'], $array['database']['dbname'], $array['database']['username'], $array['database']['password']);

            $req = Orm::getConnexion()->prepare('SHOW COLUMNS FROM '.$table);
            $req->execute();

            $list = [];
            while($res = $req->fetch()){
                $list[] = $res['Field'];
            }

            $code = "<?php\n";
            $code .= '	namespace Bundles\\'.$bundle.'\\Entity;'."\n\n";
            $code .= '	class '.ucfirst($table).'{'."\n";
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

            file_put_contents('Bundles/'.$bundle.'/Entity/'.ucfirst($table).'.php', $code);
        }
    }