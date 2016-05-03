<?php
    namespace Composants\Console\ORM;
    use Composants\Yaml\Yaml;
    use Composants\Framework\CreateLog\CreateErrorLog;
    use Composants\Framework\CreateLog\CreateRequestLog;

    /**
     * Class Createdb
     * @package Console\ORM
     */
    class Createdb{
        /**
         * Createdb constructor.
         */
        public function __construct(){
            $array = Yaml::parse(file_get_contents('Others/config/database.yml'));

            try{
                if($array['system'] == 'MySQL'){
                    $db = new \PDO('mysql:host='.$array['host'], $array['username'], $array['password']);
                    $db->exec('CREATE DATABASE IF NOT EXISTS '.$array['dbname']);
                    new CreateRequestLog('CREATE DATABASE IF NOT EXISTS '.$array['dbname']);

                    echo 'La base de données '.$array['dbname'].' a bien été créée.';
                }
            }
            catch(\PDOException $e){
                new CreateErrorLog($e->getMessage());
                die($e->getMessage());
            }
        }
    }