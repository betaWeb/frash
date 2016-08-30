<?php
    namespace Composants\ORM;

    /**
     * Class RequestFactory
     * @package Composants\ORM
     */
    class RequestFactory{
        /**
         * @param \PDO $orm
         * @param string $request
         * @return object
         */
        public function getRequest(\PDO $orm, $request){
            list($b, $r) = explode('.', $request);

            $bundle = $b.'Bundle';
            $req = $r.'Requests';

            $class = 'Bundles\\'.$bundle.'\\Requests\\'.$req;
            return new $class($orm);
        }
    }