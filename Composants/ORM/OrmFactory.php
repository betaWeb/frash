<?php
    namespace Composants\ORM;
    use Composants\ORM\Orm;

    /**
     * Class OrmFactory
     * @package Composants\ORM
     */
    class OrmFactory{
        /**
         * @param string $prefix
         * @return string
         */
        private function setPath($prefix){
            return $prefix.'Composants/Configuration/database.yml';
        }

        /**
         * @param string $bundle
         * @param string $prefix
         * @return \PDO
         */
        public function getConnexion($bundle, $prefix = ''){
            $orm = new Orm($bundle, $this->setPath($prefix));
            return $orm::getConnexion();
        }
    }