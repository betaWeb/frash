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
     * @param Dic $dic
     */
    public function preloadHydration(Dic $dic){
        $this->dic = $dic;
    }

    /**
     * @param object $object
     * @param object $entity;
     * @return object
     */
    public function hydration($object, $entity){
        $ent = new $entity($this->dic);

        foreach($object as $col => $val){
            $ent->$col = $val;
        }

        return $ent;
    }
}