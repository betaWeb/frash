<?php
    namespace Composants\ORM\MySQL\Request;

    /**
     * Class Update
     * @package Composants\ORM\MySQL\Request
     */
    class Update{
        /**
         * @var string
         */
        private $table = '';

        /**
         * @var
         */
        private $update;

        /**
         * @var
         */
        private $updateExecute;

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
         * @param array $update
         */
        public function setUpdate($update = []){
            $upd = [];
            foreach($update as $v){
                $upd[] = $v.' = ?';
            }

            $this->update = implode(', ', $upd);
            $nb = count($upd) - 1;

            for($i = 0; $i <= $nb; $i++){
                $this->updateExecute[] = '?';
            }
        }

        /**
         * @param $exec
         */
        public function setExecute($exec){
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
            if(!empty($this->table) && !empty($this->update)){
                $request = 'UPDATE '.$this->table.' SET '.$this->update;
                if($this->where != ''){ $request .= $this->where; }
                return $request;
            }
        }
    }