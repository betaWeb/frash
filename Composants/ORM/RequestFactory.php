<?php
    namespace Composants\ORM;
    use Composants\ORM\PGSQL\Counter;
    use Composants\ORM\PGSQL\Finder;

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

        /**
         * @param \PDO $orm
         * @return Counter
         */
        public function getCounter(\PDO $orm){
            return new Counter($orm);
        }

        /**
         * @param \PDO $orm
         * @return Finder
         */
        public function getFinder(\PDO $orm){
            return new Finder($orm);
        }
    }