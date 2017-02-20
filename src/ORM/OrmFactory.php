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
        $this->bundle = $dic->get('bundle');
        $this->dic = $dic;
        $orm = new Orm($this->bundle, $this->dic);
        $this->connexion = $orm->getConnexion();
        $this->system = $orm->getSystem();
    }

    /**
     * @return \PDO
     */
    public function getConnexion(){
        return $this->connexion;
    }

    /**
     * @return string
     */
    public function getSystem(){
        return $this->system;
    }

    /**
     * @return object
     */
    public function getCounter(){
        $namespace = 'Frash\ORM\\'.$this->system.'\Counter';
        return new $namespace($this->dic, $this->connexion);
    }

    /**
     * @return object
     */
    public function getEntity($entity){
        $namespace = 'Bundles\\'.$this->bundle.'\Entity\\'.$entity;
        return new $namespace;
    }

    /**
     * @return object
     */
    public function getFinder(){
        $namespace = 'Frash\ORM\\'.$this->system.'\Finder';
        return new $namespace($this->dic, $this->connexion, $this->bundle);
    }

    /**
     * @param string $request
     * @return object
     */
    public function getRequest(string $request){
        $class = 'Bundles\\'.$this->bundle.'\Requests\\'.$request.'Requests';
        return new $class($this->dic, $this->connexion);
    }
}