<?php
    namespace Composants\ORM\Request;

    /**
     * Class Select
     * @package Composants\ORM\Request
     */
    class Select{
        /**
         * @var
         */
        private $table;

        /**
         * @var string
         */
        private $colSel = '*';

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
        private $request;

        /**
         * @var
         */
        private $execute;

        /**
         * @var
         */
        private $order;

        /**
         * @var
         */
        private $limit;

        /**
         * Select constructor.
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
         * @param $order
         */
        public function setOrder($order){
            $this->order = $order;
        }

        /**
         * @param $limit
         */
        public function setLimit($limit){
            $this->limit = $limit;
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
                $this->execute = array_combine($result, $exec);
            }
        }

        /**
         *
         */
        public function requestSelect(){
            if(!empty($this->table) && !empty($this->colSel)){
                $this->request = 'SELECT '.$this->colSel.' FROM '.$this->table.' '.$this->where.' '.$this->order.' '.$this->limit;
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