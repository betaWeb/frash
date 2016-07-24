<?php
    namespace Composants\ORM\PGSQL;

    /**
     * Class Hydrator
     * @package Composants\ORM\PGSQL
     */
    class Hydrator{
        /**
         * @param array $object
         * @param string $bundle
         * @param string $entity
         * @return object
         */
        public static function hydration($object, $bundle, $entity){
            $path = 'Bundles\\'.$bundle.'\Entity\\'.$entity;
            $ent = new $path;

            foreach($object as $col => $val){
                $method = 'set'.ucfirst($col);
                $ent->$method($val);
            }

            return $ent;
        }
    }