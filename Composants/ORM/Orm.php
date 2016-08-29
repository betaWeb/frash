<?php
    namespace Composants\ORM;
    use Composants\Framework\Exception\ConnexionORMFail;
    use Composants\ORM\VerifParamDbYaml;
    use Composants\Yaml\Yaml;

    /**
     * Class Orm
     * @package Composants\ORM
     */
    class Orm{
        /**
         * @var \PDO
         */
        private static $connexion;

        /**
         * Orm constructor.
         * @param string $bundle
         * @param string $path
         * @return ConnexionORMFail
         */
        public function __construct($bundle, $path){
            if(!file_exists($path)){ return new ConnexionORMFail('Le fichier database.yml n\'existe pas.'); }

            $yaml = Yaml::parse(file_get_contents($path));

            if(empty($yaml[ $bundle ])){ return new ConnexionORMFail('Le bundle '.$bundle.' n\'existe pas.'); }

            $conn = $yaml[ $bundle ];
            new VerifParamDbYaml($conn, [ 'host', 'dbname', 'username', 'password', 'system' ]);

            try{
                switch($conn['system']){
                    case 'MySQL':
                        self::$connexion = new \PDO('mysql:host='.$conn['host'].';dbname='. $conn['dbname'].';charset=UTF8;', $conn['username'], $conn['password']);
                        break;
                    case 'PGSQL':
                        self::$connexion = new \PDO('pgsql:dbname='. $conn['dbname'].';host='.$conn['host'], $conn['username'], $conn['password']);
                        self::$connexion->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                        break;
                }
            }
            catch(\Exception $e){
                return new ConnexionORMFail($e->getMessage());
            }
        }

        /**
         * @return \PDO
         */
        public static function getConnexion(){
            return self::$connexion;
        }
    }