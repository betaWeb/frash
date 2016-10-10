<?php
    namespace Composants\Console\ORM;
    use Symfony\Component\Yaml\Yaml;
    use Composants\Framework\CreateLog\CreateErrorLog;
    use Composants\Framework\CreateLog\CreateRequestLog;

    /**
     * Class Createdb
     * @package Console\ORM
     */
    class Createdb{
        /**
         * Createdb constructor.
         * @param string $bundle
         */
        public function __construct($bundle){
            $array = Yaml::parse(file_get_contents('Composants/Configuration/database.yml'));
            $conn = $array['bundle'];

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