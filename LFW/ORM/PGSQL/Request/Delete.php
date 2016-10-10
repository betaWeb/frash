<?php
    namespace Composants\ORM\PGSQL\Request;
    use Composants\ORM\RequestInterface;

    /**
     * Class Delete
     * @package Composants\ORM\PGSQL\Request
     */
    class Delete implements RequestInterface{
        /**
         * @var string
         */
        private $table = '';

        /**
         * @var string
         */
        private $where = '';

        /**
         * @var array
         */
        private $arrayWhere = [];

        /**
         * @var array
         */
        private $execute = [];

        /**
         * Delete constructor.
         * @param $table
         */
        public function __construct($table){
            $this->table = "\"$table\"";
        }

        /**
         * @param $where
         * @param $arrayWhere
         */
        public function setWhere($where, $arrayWhere){
            $this->where = $where;
            $this->arrayWhere = $arrayWhere;
        }

        /**
         * @param array $exec
         */
        public function setExecute($exec = []){
            if(count($exec) == count($this->arrayWhere)){
                $this->execute = $exec;
            }
        }

        /**
         * @return array
         */
        public function getExecute(){
            return $this->execute;
        }

        /**
         * @return string
         */
        public function getRequest(){
            if(!empty($this->table)){
                $request = 'DELETE FROM '.$this->table;
                if($this->where != ''){ $request .= $this->where; }

                return $request;
            }
        }
    }