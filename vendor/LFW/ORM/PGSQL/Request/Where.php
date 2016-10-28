<?php
    namespace LFW\ORM\PGSQL\Request;

    /**
     * Class Where
     * @package LFW\ORM\PGSQL\Request
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
         * @return string
         */
        private function defineFunc($where){
            if(substr($where, 0, 2) == 'f '){
                return substr($where, 2);
            }
            else{
                return "\"$where\"";
            }
        }

        /**
         * @param string $where
         * @param string $sign
         * @param string $exec
         * @param string $prefix
         * @param string $suffix
         */
        public function where($where, $sign, $exec, $prefix = '', $suffix = ''){
            $this->where .= ' '.$prefix.$this->defineFunc($where).' '.$sign.' '.$exec.' '.$suffix;
            $this->arrayWhere[] = substr($exec, 1);
        }

        /**
         * @param string $where
         * @param string $sign
         * @param string $exec
         */
        public function andWhere($where, $sign, $exec){
            $this->where .= ' AND '.$this->defineFunc($where).' '.$sign.' '.$exec;
            $this->arrayWhere[] = substr($exec, 1);
        }

        /**
         * @param string $where
         * @param string $sign
         * @param string $exec
         */
        public function orWhere($where, $sign, $exec){
            $this->where .= ' OR '.$this->defineFunc($where).' '.$sign.' '.$exec;
            $this->arrayWhere[] = substr($exec, 1);
        }

        /**
         * @param string $where
         */
        public function isNullWhere($where){
            $this->where .= $where.' IS NULL';
        }

        /**
         * @param string $where
         */
        public function isNotNullWhere($where){
            $this->where .= $where.' IS NOT NULL';
        }

        /**
         * @param string $where
         * @param string $exec
         */
        public function inWhere($where, $exec){
            $this->where .= $where.' IN ('.$exec.')';
            $this->arrayWhere[] = substr($exec, 1);
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