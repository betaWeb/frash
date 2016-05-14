<?php
    namespace Composants\Framework\ORM\PGSQL\Request;

    /**
     * Class Insert
     * @package Composants\Framework\ORM\PGSQL\Request
     */
    class Insert{
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
         * @var string
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
            $this->table = "\"$table\"";
        }

        /**
         * @param $val
         */
        public function setInsert($val){
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
         * @return string
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