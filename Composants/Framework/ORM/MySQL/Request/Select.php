<?php
    namespace Composants\Framework\ORM\MySQL\Request;

    /**
     * Class Select
     * @package Composants\Framework\ORM\MySQL\Request
     */
    class Select{
        /**
         * @var string
         */
        private $table = '';

        /**
         * @var string
         */
        private $colSel = '*';

        /**
         * @var string
         */
        private $where = '';

        /**
         * @var string
         */
        private $arrayWhere = '';

        /**
         * @var array
         */
        private $execute;

        /**
         * @var string
         */
        private $order = '';

        /**
         * @var string
         */
        private $limit = '';

        /**
         * @var string
         */
        private $join_type = '';

        /**
         * @var string
         */
        private $join_table = '';

        /**
         * @var string
         */
        private $join_comp = '';

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
         * @param $type
         * @param $table
         * @param $comp
         */
        public function setJoin($type, $table, $comp){
            $this->join_type = $type;
            $this->join_table = $table;
            $this->join_comp = $comp;
        }

        /**
         * @param $order
         */
        public function setOrder($order){
            $this->order = 'ORDER BY '.$order;
        }

        /**
         * @param $limit
         */
        public function setLimit($limit){
            $this->limit = 'LIMIT '.$limit;
        }

        /**
         * @param $col
         */
        public function setColSel($col){
            $this->colSel = $col;
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
         * @return array
         */
        public function getExecute(){
            return $this->execute;
        }

        /**
         * @return string
         */
        public function getRequest(){
            if(!empty($this->table) && !empty($this->colSel)){
                return 'SELECT '.$this->colSel.' FROM '.$this->table.' '.$this->where.' '.$this->order.' '.$this->limit;
            }
        }

        /**
         * @return string
         */
        public function getRequestJoin(){
            if(!empty($this->table) && !empty($this->colSel) && $this->join_comp != '' && $this->join_table != '' && $this->join_type != ''){
                return 'SELECT '.$this->colSel.' FROM '.$this->table.' '.$this->join_type.' '.$this->join_table.' ON '.$this->join_comp.' '.$this->where.' '.$this->order.' '.$this->limit;
            }
        }
    }