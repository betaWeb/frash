<?php
    namespace LFW\ORM\PGSQL\Request;

    /**
     * Class ComplexWhere
     * @package LFW\ORM\PGSQL\Request
     */
    class ComplexWhere{
        /**
         * @var string
         */
        private $where = 'WHERE ';

        /**
         * @var array
         */
        private $arrayWhere = [];

        /**
         * @param array $where
         */
        public function setWhere($where){
            $this->where .= implode(' ', $where);
        }

        /**
         * @param string $where
         * @param string $sign
         * @param string $exec
         */
        public function normal($where, $sign, $exec){
            $this->arrayWhere[] = substr($exec, 1);
            return "\"$where\"".' '.$sign.' '.$exec;
        }

        /**
         * @param string $where
         */
        public function isNull($where){
            return "\"$where\"".' IS NULL';
        }

        /**
         * @param string $where
         */
        public function isNotNull($where){
            return "\"$where\"".' IS NOT NULL';
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