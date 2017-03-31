<?php
namespace Frash\ORM;
use Frash\Framework\DIC\Dic;

/**
 * Class Hydrator
 * @package Frash\ORM
 */
class Hydrator{
    /**
     * @var Dic
     */
    private $dic;

    /**
     * @var Dic
     */
    private $orm;

    /**
     * @param OrmFactory $orm
     * @param Dic $dic
     */
    public function preloadHydration(OrmFactory $orm, Dic $dic){
        $this->dic = $dic;
        $this->orm = $orm;
    }

    /**
     * @param object $object
     * @param object $entity;
     * @return object
     */
    public function hydration($object, $entity){
        $ent = new $entity($this->orm, $this->dic);

        foreach($object as $col => $val){
            $ent->$col = $val;
        }

        return $ent;
    }
}