<?php
namespace Frash\ORM;
use Frash\Framework\DIC\Dic;
use Frash\ORM\Orm;

/**
 * Class OrmFactory
 * @package Frash\ORM
 */
class OrmFactory{
    /**
     * @var string
     */
    private $bundle;

    /**
     * @var Dic
     */
    private $dic;

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var string
     */
    private $system;

    /**
     * OrmFactory constructor.
     * @param Dic $dic
     */
    public function __construct(Dic $dic){
        $this->dic = $dic;
        $this->bundle = $this->dic->bundle;

        $orm = new Orm($dic);
        $this->pdo = $orm->connexion;
        $this->system = $orm->system;
    }

    public function __get(string $prop){
        return $this->$prop;
    }

    /**
     * @return object
     */
    public function counter(){
        $namespace = 'Frash\ORM\Query\Counter';
        return new $namespace($this->dic);
    }

    /**
     * @return object
     */
    public function entity(string $entity){
        $namespace = 'Bundles\\'.$this->bundle.'\Entity\\'.$entity;
        return new $namespace($this->dic);
    }

    /**
     * @return object
     */
    public function finder(){
        $namespace = 'Frash\ORM\Query\Finder';
        return new $namespace($this->dic);
    }

    /**
     * @param string $request
     * @return object
     */
    public function request(string $request){
        $class = 'Bundles\\'.$this->bundle.'\Repository\\'.$request.'Repository';
        return new $class($this->dic);
    }
}