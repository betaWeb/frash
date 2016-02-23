<?php
    namespace Composants\ORM\Request;

    /**
     * Class Where
     * @package Composants\ORM\Request
     */
    class Where{
        /**
         * @var string
         */
        private $where = ' WHERE ';

        /**
         * @var array
         */
        private $arrayWhere = [];

        /**
         * @param $where
         * @param $sign
         */
        public function initNormalWhere($where, $sign){
            $this->where .= $where[0].' '.$sign.' '.$where[1];
            $this->arrayWhere[] = $where[1];
        }

        /**
         * @param $where
         * @param $sign
         */
        public function andWhere($where, $sign){
            $this->where .= ' AND '.$where[0].' '.$sign.' '.$where[1];
            $this->arrayWhere[] = $where[1];
        }

        /**
         * @param $where
         * @param $sign
         */
        public function orWhere($where, $sign){
            $this->where .= ' OR '.$where[0].' '.$sign.' '.$where[1];
            $this->arrayWhere[] = $where[1];
        }

        /**
         * @param $where
         */
        public function isNullWhere($where){
            $this->where .= $where.' IS NULL';
        }

        /**
         * @param $where
         */
        public function isNotNullWhere($where){
            $this->where .= $where.' IS NOT NULL';
        }

        /**
         * @return array
         */
        public function getArrayWhere(){
            return $this->arrayWhere;
        }

        /**
         * @return string
         */
        public function getWhere(){
            return $this->where;
        }
    }