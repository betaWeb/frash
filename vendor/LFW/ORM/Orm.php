<?php
namespace LFW\ORM;
use LFW\Framework\Exception\Exception;
use LFW\Framework\FileSystem\InternalJson;
use LFW\ORM\PDO;

/**
 * Class Orm
 * @package LFW\ORM
 */
class Orm{
    /**
     * @var \PDO
     */
    private $connexion;

    /**
     * @var string
     */
    private $system;

    /**
     * Orm constructor.
     * @param string $bundle
     * @return Exception
     */
    public function __construct(string $bundle){
        $json = InternalJson::importDatabase()[ $bundle ];
        $this->system = $json['system'];

        try{
            switch($json['system']){
                case 'MySQL':
                    $this->connexion = new \PDO('mysql:host='.$json['host'].';dbname='. $json['dbname'].';charset=UTF8;', $json['username'], $json['password'], []);
                    break;
                case 'PGSQL':
                    $this->connexion = new \PDO('pgsql:dbname='.$json['dbname'].';port='.$json['port'].';host='.$json['host'], $json['username'], $json['password']);
                    $this->connexion->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                    break;
                default:
                    return new Exception('Le bundle '.$bundle.' n\'existe pas.');
            }
        }
        catch(\Exception $e){
            return new Exception($e->getMessage());
        }
    }

    /**
     * @return \PDO
     */
    public function getConnexion(): \PDO{
        return $this->connexion;
    }

    /**
     * @return string
     */
    public function getSystem(): string{
        return $this->system;
    }
}