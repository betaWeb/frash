<?php
    namespace Composants\ORM\PDO;

    /**
     * Class PDO
     * @package Composants\ORM\PDO
     */
    class PDO{
        /**
         * @var \PDO
         */
        private $pdo;

        /**
         * @var int
         */
        private $count_req = 0;

        /**
         * @var
         */
        private $results;

        /**
         * PDO constructor.
         * @param string $dsn
         * @param string $username
         * @param string $passwd
         * @param array $options
         */
        public function __construct($dsn, $username, $passwd, $options = []){
            $this->pdo = new \PDO($dsn, $username, $passwd, $options = []);
        }

        /**
         * @param int $attribute
         * @param mixed $value
         */
        public function setAttribute($attribute, $value){
            $this->pdo->setAttribute($attribute, $value);
        }

        /**
         * @param string $request
         * @param array $params
         */
        public function request($request, $params = []){
            $this->incrementCountReq();

            $this->results = $this->pdo->prepare($request);
            $this->results->execute($params);
        }

        /**
         * @return array
         */
        public function fetchAll(){
            return $this->results->fetchAll(\PDO::FETCH_OBJ);
        }

        /**
         * @return array
         */
        public function fetch(){
            return $this->results->fetch(\PDO::FETCH_OBJ);
        }

        /**
         * @return int
         */
        public function rowCount(){
            return $this->results->rowCount();
        }

        /**
         * @param string $sequence
         * @return int
         */
        public function lastInsertId($sequence){
            return $this->pdo->lastInsertId($sequence);
        }

        /**
         * @param string $param
         * @return string
         */
        public function quote($param){
            return $this->pdo->quote($param);
        }

        /**
         * @return int
         */
        public function getCountReq(){
            return $this->count_req;
        }

        private function incrementCountReq(){
            $this->count_req += 1;
        }
    }