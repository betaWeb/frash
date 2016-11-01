<?php
    namespace LFW\ORM;
    use LFW\Framework\UpperCamelCase;

    /**
     * Class Hydrator
     * @package LFW\ORM
     */
    class Hydrator{
        /**
         * @param array $object
         * @return object
         */
        public function hydration($object, $entity){
            $ent = new $entity;

            foreach($object as $col => $val){
                $method = (strstr($col, '_')) ? 'set'.ucfirst(UpperCamelCase::treatment($col)) : 'set'.ucfirst($col);
                $ent->$method($val);
            }

            return $ent;
        }
    }