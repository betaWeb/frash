<?php
    namespace Composants\ORM\PGSQL\Request;

    /**
     * Class Where
     * @package Composants\ORM\PGSQL\Request
     */
    class Where{
        /**
         * @var string
         */
        private $where = 'WHERE ';

        /**
         * @var array
         */
        private $arrayWhere = [];

        /**
         * @param string $where
         * @param string $sign
         * @param string $exec
         * @param string $prefix
         * @param string $suffix
         */
        public function where($where, $sign, $exec, $prefix = '', $suffix = ''){
            $this->where .= ' '.$prefix."\"$where\"".' '.$sign.' '.$exec.' '.$suffix;
            $this->arrayWhere[] = $exec[0];
        }

        /**
         * @param string $where
         * @param string $sign
         * @param string $exec
         */
        public function andWhere($where, $sign, $exec){
            $this->where .= ' AND '."\"$where\"".' '.$sign.' '.$exec;
            $this->arrayWhere[] = $exec[0];
        }

        /**
         * @param string $where
         * @param string $sign
         * @param string $exec
         */
        public function orWhere($where, $sign, $exec){
            $this->where .= ' OR '."\"$where\"".' '.$sign.' '.$exec;
            $this->arrayWhere[] = $exec[0];
        }

        /**
         * @param string $where
         */
        public function isNullWhere($where){
            $this->where .= "\"$where\"".' IS NULL';
        }

        /**
         * @param string $where
         */
        public function isNotNullWhere($where){
            $this->where .= "\"$where\"".' IS NOT NULL';
        }

        /**
         * @param string $where
         * @param string $exec
         */
        public function inWhere($where, $exec){
            $this->where .= "\"$where\"".' IN ('.$exec.')';
            $this->arrayWhere[] = $exec[0];
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