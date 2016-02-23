<?php
    namespace Composants\ORM\Request;

    /**
     * Class Update
     * @package Composants\ORM\Request
     */
    class Update{
        /**
         * @var
         */
        private $table;

        /**
         * @var
         */
        private $update;

        /**
         * @var
         */
        private $updateExecute;

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
         * Update constructor.
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
         * @param $update
         */
        public function setUpdate($update){
            $this->update = implode(', ', $update);

            foreach($update as $v){
                $val = explode(' = ', $v);
                $this->updateExecute[] = $val[1];
            }
        }

        /**
         * @param bool $exec
         */
        public function setExecute($exec = false){
            $arrayNotExec = [];

            if(count($this->updateExecute) == 1){
                $arrayNotExec = $this->updateExecute;
            }
            else{
                foreach($this->updateExecute as $v){
                    $arrayNotExec[] = $v;
                }
            }

            if(!empty($this->arrayWhere)){
                $result = array_merge($arrayNotExec, explode(' ||| ', $this->arrayWhere));
            }
            else{
                $result = $arrayNotExec;
            }

            if(count($exec) == count($result)){
                $this->execute = array_combine($result, $exec);
            }
        }

        /**
         *
         */
        public function requestUpdate(){
            if(!empty($this->table) && !empty($this->update)){
                $this->request = 'UPDATE '.$this->table.' SET '.$this->update;
                if($this->where != ''){ $this->request .= $this->where; }
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