<?php
namespace LFW\Console\ORM;
use LFW\Console\CommandInterface;
use LFW\Framework\CreateLog\{ CreateErrorLog, CreateRequestLog };
use LFW\Framework\FileSystem\Json;

/**
 * Class Createdb
 * @package LFW\Console\ORM
 */
class Createdb implements CommandInterface{
    /**
     * @var string
     */
    private $bundle = '';

    /**
     * Createdb constructor.
     * @param array $argv
     */
    public function __construct(array $argv){
        $this->bundle = $argv[2];
    }

    public function work(){
        $conn = (array) Json::importDatabaseArray()[ $this->bundle ]['bundle'];

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