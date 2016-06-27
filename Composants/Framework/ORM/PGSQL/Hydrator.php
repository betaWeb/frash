<?php
    namespace Composants\Framework\ORM\PGSQL;

    /**
     * Class Hydrator
     * @package Composants\Framework\ORM\PGSQL
     */
    class Hydrator{
        /**
         * @param array $object
         * @param string $bundle
         * @param string $entity
         * @return object
         */
        public function hydration($object, $bundle, $entity){
            $path = 'Bundles\\'.$bundle.'\Entity\\'.$entity;
            $ent = new $path;

            foreach($object as $col => $val){
                $method = 'set'.ucfirst($col);
                $ent->$method($val);
            }

            return $ent;
        }
    }