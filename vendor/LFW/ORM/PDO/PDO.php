<?php
    namespace LFW\ORM\PDO;

    /**
     * Class PDO
     * @package LFW\ORM\PDO
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
         * @var object
         */
        private $results;

        /**
         * PDO constructor.
         * @param string $dsn
         * @param string $username
         * @param string $passwd
         * @param array $options
         */
        public function __construct(string $dsn, string $username, string $passwd, array $options = []){
            $this->pdo = new \PDO($dsn, $username, $passwd, $options = []);
        }

        /**
         * @param int $attribute
         * @param mixed $value
         */
        public function setAttribute(int $attribute, $value){
            $this->pdo->setAttribute($attribute, $value);
        }

        /**
         * @param string $request
         * @param array $params
         */
        public function request(string $request, array $params = []){
            $this->incrementCountReq();

            $this->results = $this->pdo->prepare($request);
            $this->results->execute($params);
        }

        /**
         * @return array
         */
        public function fetchAssoc(): array{
            return $this->results->fetch(\PDO::FETCH_ASSOC);
        }

        /**
         * @return array
         */
        public function fetchObj(){
            return $this->results->fetch(\PDO::FETCH_OBJ);
        }

        /**
         * @return array
         */
        public function fetchAllAssoc(){
            return $this->results->fetchAll(\PDO::FETCH_ASSOC);
        }

        /**
         * @return array
         */
        public function fetchAllObj(){
            return $this->results->fetchAll(\PDO::FETCH_OBJ);
        }

        /**
         * @return int
         */
        public function rowCount(): int{
            return $this->results->rowCount();
        }

        /**
         * @param string $sequence
         * @return int
         */
        public function lastInsertId(string $sequence = ''): int{
            return ($sequence == '') ? $this->pdo->lastInsertId() : $this->pdo->lastInsertId($sequence);
        }

        /**
         * @param string $param
         * @return string
         */
        public function quote(string $param): string{
            return $this->pdo->quote($param);
        }

        /**
         * @return int
         */
        public function getCountReq(): int{
            return $this->count_req;
        }

        private function incrementCountReq(){
            $this->count_req += 1;
        }
    }