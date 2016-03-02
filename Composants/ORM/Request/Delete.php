<?php
    namespace Composants\ORM\Request;

    /**
     * Class Delete
     * @package Composants\ORM\Request
     */
    class Delete{
        /**
         * @var
         */
        private $table;

        /**
         * @var
         */
        private $where;

        /**
         * @var
         */
        private $arrayWhere;

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
         * @param $exec
         */
        public function setExecute($exec){
            $val = str_replace(':', '', $this->arrayWhere);
            $resval = explode(' ||| ', $val);
            $this->execute = array_combine($resval, $exec);
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