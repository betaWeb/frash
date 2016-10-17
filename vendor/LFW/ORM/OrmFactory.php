<?php
    namespace LFW\ORM;
    use LFW\ORM\Orm;

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
            $this->bundle = $bundle.'Bundle';
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
            $class = 'Bundles\\'.$this->bundle.'\Requests\\'.$request.'Requests';
            return new $class($this->connexion);
        }
    }