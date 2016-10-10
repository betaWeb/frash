<?php
    namespace LFW\ORM;
    use LFW\ORM\Orm;
    use LFW\ORM\PGSQL\Counter;
    use LFW\ORM\PGSQL\Finder;

    /**
     * Class OrmFactory
     * @package LFW\ORM
     */
    class OrmFactory{
        /**
         * @var \PDO
         */
        private $connexion;

        /**
         * @var string
         */
        private $bundle;

        /**
         * OrmFactory constructor.
         * @param string $bundle
         */
        public function __construct($bundle){
            $this->bundle = $bundle;
            $orm = new Orm($this->bundle);
            $this->connexion = $orm->getConnexion();
        }

        /**
         * @return \PDO
         */
        public function getConnexion(){
            return $this->connexion;
        }

        /**
         * @param string $request
         * @return object
         */
        public function getRequest($request){
            $class = 'Bundles\\'.$this->bundle.'Bundle\Requests\\'.$request.'Requests';
            return new $class($this->connexion);
        }

        /**
         * @return Counter
         */
        public function getCounter(){
            return new Counter($this->connexion);
        }

        /**
         * @return Finder
         */
        public function getFinder(){
            return new Finder($this->connexion);
        }
    }