<?php
    namespace LFW\ORM\PGSQL\Request;
    use LFW\ORM\RequestInterface;

    /**
     * Class Update
     * @package LFW\ORM\PGSQL\Request
     */
    class Update implements RequestInterface{
        /**
         * @var string
         */
        private $table = '';

        /**
         * @var string
         */
        private $update = '';

        /**
         * @var array
         */
        private $updateExecute = [];

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
         * Update constructor.
         * @param string $table
         */
        public function __construct($table){
            $this->table = $table;
        }

        /**
         * @param string $exec
         */
        public function setAddExec($exec){
            $this->updateExecute[] = $exec;
        }

        /**
         * @param string $where
         * @param array $arrayWhere
         */
        public function setWhere(Where $where){
            $this->where = $where->getWhere();
            $this->arrayWhere = $where->getArrayWhere();
        }

        /**
         * @param array $update
         */
        public function setUpdate($update = []){
            $upd = [];

            foreach($update as $k => $v){
                $comp = substr($k, -2);
                $col = substr($k, 0, -2);

                switch($comp){
                    case ' +':
                        $upd[] = "\"$col\" = \"$col\" + ".$v;
                        $this->updateExecute[] = substr($v, 1);
                        break;
                    case ' -':
                        $upd[] = "\"$col\" = \"$col\" - ".$v;
                        $this->updateExecute[] = substr($v, 1);
                        break;
                    case ' /':
                        $upd[] = "\"$col\"".' = '.$v;
                        break;
                    default:
                        $upd[] = "\"$k\"".' = '.$v;
                        $this->updateExecute[] = substr($v, 1);
                }
            }

            $this->update = implode(', ', $upd);
        }

        /**
         * @param array $exec
         */
        public function setExecute($exec){
            $arrayUpd = [];

            foreach($this->updateExecute as $v){
                $arrayUpd[] = $v;
            }

            $result = array_merge($arrayUpd, $this->arrayWhere);

            if(count($exec) == count($result)){
                $this->execute = array_combine($result, $exec);
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
            if(!empty($this->table) && !empty($this->update)){
                $request = 'UPDATE '.$this->table.' SET '.$this->update.' ';
                if($this->where != ''){ $request .= $this->where; }
                return $request;
            }
        }
    }