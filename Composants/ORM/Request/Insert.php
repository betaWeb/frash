<?php
    namespace Composants\ORM\Request;

    /**
     * Class Insert
     * @package Composants\ORM\Request
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
         * @var
         */
        private $execute;

        /**
         * @var
         */
        private $request;

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
            $val = str_replace(':', '', $this->insertExecute);
            $resval = explode(' ||| ', $val);
            $this->execute = array_combine($resval, $exec);
        }

        /**
         *
         */
        public function requestInsert(){
            if(!empty($this->table)){
                if(!empty($this->insertCol) && !empty($this->insertVal) && count($this->insertCol) == count($this->insertVal)){
                    $this->request = 'INSERT INTO '.$this->table.' ('.$this->insertCol.') VALUES ('.$this->insertVal.')';
                    echo $this->request;
                }
            }
        }

        /**
         * @return mixed
         */
        public function getExecute(){
            return $this->execute;
        }

        /**
         * @return mixed
         */
        public function getRequest(){
            return $this->request;
        }
    }