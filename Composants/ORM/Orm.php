<?php
    namespace Composants\ORM;
    use Composants\Framework\Exception\ConnexionORMFail;
    use Composants\Yaml\Yaml;

    /**
     * Class Orm
     * @package Composants\ORM
     */
    class Orm{
        /**
         * @var object
         */
        private $connexion;

        /**
         * @return ConnexionORMFail
         */
        public function __construct($bundle, $pathyml){
            $conn = Yaml::parse(file_get_contents($pathyml));

            $host = $conn[ $bundle ]['host'];
            $dbname = $conn[ $bundle ]['dbname'];
            $username = $conn[ $bundle ]['username'];
            $password = $conn[ $bundle ]['password'];
            $system = $conn[ $bundle ]['system'];

            try{
                if($system == 'MySQL'){
                    $this->connexion = new \PDO('mysql:host='.$host.';dbname='.$dbname.';charset=UTF8;', $username, $password, [ \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC ]);
                }
                elseif($system == 'PGSQL'){
                    $this->connexion = new \PDO('pgsql:dbname='.$dbname.';host='.$host, $username, $password);
                    $this->connexion->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                }
            }
            catch(\Exception $e){
                return new ConnexionORMFail($e->getMessage());
            }
        }

        /**
         * @return object
         */
        public function getConnexion(){
            return $this->connexion;
        }
    }