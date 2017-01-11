<?php
    namespace LFW\ORM;

    /**
     * Class Hydrator
     * @package LFW\ORM
     */
    class Hydrator{
        /**
         * @param object $object
         * @param object $entity;
         * @return object
         */
        public function hydration($object, $entity){
            $ent = new $entity;

            foreach($object as $col => $val){
                $ent->$col = $val;
            }

            return $ent;
        }
    }