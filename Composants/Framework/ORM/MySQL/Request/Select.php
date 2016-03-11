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
         * @var
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
            if(!empty($this->table) && !empty($this->colSel)){
                return 'SELECT '.$this->colSel.' FROM '.$this->table.' '.$this->where.' '.$this->order.' '.$this->limit;
            }
        }
    }