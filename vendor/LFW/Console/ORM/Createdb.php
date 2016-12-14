<?php
    namespace LFW\Console\ORM;
    use LFW\Framework\CreateLog\{ CreateErrorLog, CreateRequestLog };
    use LFW\Framework\FileSystem\Json;

    /**
     * Class Createdb
     * @package LFW\Console\ORM
     */
    class Createdb{
        /**
         * Createdb constructor.
         * @param string $bundle
         */
        public function __construct(string $bundle){
            $conn = Json::importConfigArray()['bundle'];

            try{
                if($conn['system'] == 'MySQL'){
                    $db = new \PDO('mysql:host='.$conn['host'], $conn['username'], $conn['password']);
                    $db->exec('CREATE DATABASE IF NOT EXISTS '.$conn['dbname']);
                    new CreateRequestLog('CREATE DATABASE IF NOT EXISTS '.$conn['dbname']);

                    echo 'La base de données '.$conn['dbname'].' a bien été créée.';
                }
            }
            catch(\PDOException $e){
                new CreateErrorLog($e->getMessage());
                die($e->getMessage());
            }
        }
    }