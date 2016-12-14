<?php
    namespace LFW\ORM\PGSQL\Request;
    use LFW\ORM\RequestInterface;

    /**
     * Class Insert
     * @package LFW\ORM\PGSQL\Request
     */
    class Insert implements RequestInterface{
        /**
         * @var string
         */
        private $table;

        /**
         * @var string
         */
        private $insertCol;

        /**
         * @var string
         */
        private $insertVal;

        /**
         * @var array
         */
        private $insertExecute;

        /**
         * @var array
         */
        private $execute = [];

        /**
         * Insert constructor.
         * @param string $table
         */
        public function __construct(string $table){
            $this->table = "\"$table\"";
        }

        /**
         * @param array $val
         */
        public function setInsert(array $val){
            $tableau = $val;
            $transf = [];
            foreach($tableau as $t){
                $transf[] = "\"$t\"";
            }

            $this->insertCol = implode(', ', $transf);

            $array = [];
            foreach($val as $v){
                $array[] = ':'.$v;
            }

            $this->insertVal = implode(', ', $array);
            $this->insertExecute = $array;
        }

        /**
         * @param array $exec
         */
        public function setExecute(array $exec){
            $this->execute = array_combine($this->insertExecute, $exec);
        }

        /**
         * @return string
         */
        public function getRequest(): string{
            return 'INSERT INTO '.$this->table.' ('.$this->insertCol.') VALUES ('.$this->insertVal.')';
        }

        /**
         * @return array
         */
        public function getExecute(): array{
            return $this->execute;
        }

        /**
         * @return string
         */
        public function getTable(): string{
            return $this->table;
        }
    }