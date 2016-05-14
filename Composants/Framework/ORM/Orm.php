<?php
    namespace Composants\Framework\ORM;
    use Composants\Framework\CreateLog\CreateErrorLog;
    use Composants\Framework\Exception\ConnexionORMFail;
    use Composants\Yaml\Yaml;

    /**
     * Class Orm
     * @package Composants\Framework\ORM
     */
    class Orm{
        /**
         * @var string
         */
        private static $connexion = '';

        /**
         * @param $host
         * @param $db
         * @param $user
         * @param $password
         * @return ConnexionORMFail
         */
        public static function init($host, $db, $user, $password){
            $conn = Yaml::parse(file_get_contents('Others/config/database.yml'));

            try{
                if($conn['system'] == 'MySQL'){
                    self::$connexion = new \PDO('mysql:host='.$host.';dbname='.$db.';charset=UTF8;', $user, $password, [ \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC ]);
                }
                elseif($conn['system'] == 'PGSQL'){
                    self::$connexion = new \PDO('pgsql:dbname='.$db.';host='.$host, $user, $password);
                    self::$connexion->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                }
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                return new ConnexionORMFail();
            }
        }

        /**
         * @return string
         */
        public static function getConnexion(){ return self::$connexion; }
    }