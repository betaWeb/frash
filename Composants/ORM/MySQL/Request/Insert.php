<?php
    namespace Composants\ORM\MySQL\Request;

    /**
     * Class Insert
     * @package Composants\ORM\MySQL\Request
     */
    class Insert{
        /**
         * @var
         */
        private $table;

        /**
         * @var
         */
        private $insertCol;

        /**
         * @var
         */
        private $insertVal;

        /**
         * @var
         */
        private $insertExecute;

        /**
         * @var array
         */
        private $execute = [];

        /**
         * Insert constructor.
         * @param $table
         */
        public function __construct($table){
            $this->table = $table;
        }

        /**
         * @param $val
         */
        public function setInsert($val){
            $this->insertCol = implode(', ', $val);

            $array = [];
            foreach($val as $v){
                $array[] = ':'.$v;
            }

            $this->insertVal = implode(', ', $array);
            $this->insertExecute = implode(' ||| ', $array);
        }

        /**
         * @param $exec
         */
        public function setExecute($exec){
            $resval = explode(' ||| ', $this->insertExecute);
            $this->execute = array_combine($resval, $exec);
        }

        /**
         * @return mixed
         */
        public function getRequest(){
            return 'INSERT INTO '.$this->table.' ('.$this->insertCol.') VALUES ('.$this->insertVal.')';
        }

        /**
         * @return array
         */
        public function getExecute(){
            return $this->execute;
        }
    }