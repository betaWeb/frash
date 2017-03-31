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
     * @var \PDO
     */
    private $connexion;

    /**
     * @var Dic
     */
    private $dic;

    /**
     * @var string
     */
    private $system;

    /**
     * OrmFactory constructor.
     * @param Dic $dic
     */
    public function __construct(Dic $dic){
        $this->bundle = $dic->bundle;
        $this->dic = $dic;

        $orm = new Orm($this->dic);
        $this->connexion = $orm->connexion;
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
        return new $namespace($this->dic, $this->connexion);
    }

    /**
     * @return object
     */
    public function entity(string $entity){
        $namespace = 'Bundles\\'.$this->bundle.'\Entity\\'.$entity;
        return new $namespace($this, $this->dic);
    }

    /**
     * @return object
     */
    public function finder(){
        $namespace = 'Frash\ORM\Query\Finder';
        return new $namespace($this->dic, $this->connexion);
    }

    /**
     * @param string $request
     * @return object
     */
    public function request(string $request){
        $class = 'Bundles\\'.$this->bundle.'\Repository\\'.$request.'Repository';
        return new $class($this->dic, $this->connexion);
    }
}