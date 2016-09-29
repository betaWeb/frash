<?php
    namespace Composants\ORM;

    /**
     * Class Hydrator
     * @package Composants\ORM
     */
    class Hydrator{
        /**
         * @param array $object
         * @param string $entity
         * @return object
         */
        public static function hydration($object, $entity){
            $ent = new $entity;

            foreach($object as $col => $val){
                $method = 'set'.ucfirst($col);
                $ent->$method($val);
            }

            return $ent;
        }

        /**
         * @param array $object
         * @param string $entity
         * @return object
         */
        public function hydrationObject($object, $entity){
            $ent = new $entity;

            foreach($object as $col => $val){
                $method = 'set'.ucfirst($col);
                $ent->$method($val);
            }

            return (object) $ent;
        }
    }