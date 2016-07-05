<?php
    namespace Composants\Framework\ORM\PGSQL\Request;

    /**
     * Class Select
     * @package Composants\Framework\ORM\PGSQL\Request
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
         * @var array
         */
        private $arrayWhere = [];

        /**
         * @var array
         */
        private $execute = [];

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
         * @param array $array
         */
        public function __construct($array){
            $table = $array['table'];
            $this->table = "\"$table\"";

            if(!empty($array['order'])){
                $this->order = 'ORDER BY '.$array['order'];
            }

            if(!empty($array['limit'])){
                $this->limit = 'LIMIT '.$array['limit'];
            }
        }

        /**
         * @param Where $where
         */
        public function setWhere(Where $where){
            $this->where = $where->getWhere();
            $this->arrayWhere = $where->getArrayWhere();
        }

        /**
         * @param string $col
         */
        public function setColSel($col){
            $this->colSel = $col;
        }

        /**
         * @param array $exec
         */
        public function setExecute($exec = []){
            if(count($exec) == count($this->arrayWhere)){
                $this->execute = array_combine($this->arrayWhere, $exec);
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
    }