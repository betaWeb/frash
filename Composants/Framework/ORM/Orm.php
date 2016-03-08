<?php
    namespace Composants\Framework\ORM;
    use Composants\Framework\CreateLog\CreateErrorLog;
    use Composants\Framework\Exception\ConnexionORMFail;

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
            try{
                self::$connexion = new \PDO('mysql:host='.$host.';dbname='.$db.';charset=UTF8;', $user, $password, [ \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC ]);
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