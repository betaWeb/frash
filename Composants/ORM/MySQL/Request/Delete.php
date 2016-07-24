<?php
    namespace Composants\ORM\MySQL\Request;

    /**
     * Class Delete
     * @package Composants\ORM\MySQL\Request
     */
    class Delete{
        /**
         * @var string
         */
        private $table = '';

        /**
         * @var string
         */
        private $where = '';

        /**
         * @var string
         */
        private $arrayWhere = '';

        /**
         * @var
         */
        private $execute;

        /**
         * Delete constructor.
         * @param $table
         */
        public function __construct($table){
            $this->table = $table;
        }

        /**
         * @param $where
         * @param $arrayWhere
         */
        public function setWhere($where, $arrayWhere){
            $this->where = $where;
            $this->arrayWhere = implode(' ||| ', $arrayWhere);
        }

        /**
         * @param bool $exec
         */
        public function setExecute($exec = []){
            if(!empty($this->arrayWhere)){
                $result = explode(' ||| ', $this->arrayWhere);
            }
            else{
                $result = [];
            }

            if(count($exec) == count($result)){
                $this->execute = $exec;
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
            if(!empty($this->table)){
                $request = 'DELETE FROM '.$this->table;
                if($this->where != ''){ $request .= $this->where; }

                return $request;
            }
        }
    }