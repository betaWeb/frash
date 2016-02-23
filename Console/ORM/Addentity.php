<?php
    namespace Console\ORM;
    use Composants\ORM\Orm;
    use Composants\Yaml\Yaml;

    /**
     * Class Addentity
     * @package Console\ORM
     */
    class Addentity{
        /**
         * Addentity constructor.
         * @param $table
         * @param $champ
         */
        public function __construct($table, $bundle, $champ){
            $array = Yaml::parse(file_get_contents('Others/config/config.yml'));
            Orm::init($array['database']['host'], $array['database']['dbname'], $array['database']['username'], $array['database']['password']);

            $champs = explode('/', $champ);
            $pk = 'false';
            $list = [];

            $request = 'CREATE TABLE '.$table.' (';
            foreach($champs as $c){
                $colonne = explode('!', $c);
                $list[] = $colonne[0];

                foreach($colonne as $co){
                    if($co != 'auto_increment'){
                        $request .= $co.' ';
                    }
                }

                if(end($colonne) == 'auto_increment'){
                    $request .= end($colonne);
                    $pk = $colonne[0];
                }

                $request .= ', ';
            }

            if($pk != 'false'){
                $request .= 'PRIMARY KEY ('.$pk.')';
            }
            $request .= ')';

            $tab = Orm::getConnexion()->prepare($request);
            $tab->execute();

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