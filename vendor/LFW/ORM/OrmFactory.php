<?php
    namespace LFW\ORM;
    use LFW\Framework\DIC\Dic;
    use LFW\ORM\Orm;

    /**
     * Class OrmFactory
     * @package LFW\ORM
     */
    class OrmFactory{
        /**
         * @var string
         */
        private $bundle;

        /**
         * @var \PDO
         */
        private $connexion;

        /**
         * @var Dic
         */
        private $dic;

        /**
         * @var string
         */
        private $system;

        /**
         * OrmFactory constructor.
         * @param Dic $dic
         */
        public function __construct(Dic $dic){
            $this->bundle = $dic->load('get')->get('bundle');
            $this->dic = $dic;
            $orm = new Orm($this->bundle);
            $this->connexion = $orm->getConnexion();
            $this->system = $orm->getSystem();
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
        public function getRequest(string $request){
            $class = 'Bundles\\'.$this->bundle.'\Requests\\'.$request.'Requests';
            return new $class($this->connexion, $this->bundle);
        }

        /**
         * @return object
         */
        public function getCounter(){
            $namespace = 'LFW\ORM\\'.$this->system.'\Counter';
            return new $namespace($this->connexion);
        }

        /**
         * @return object
         */
        public function getFinder(){
            $namespace = 'LFW\ORM\\'.$this->system.'\Finder';
            return new $namespace($this->connexion, $this->bundle);
        }
    }