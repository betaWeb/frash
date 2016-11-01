<?php
    namespace LFW\ORM\PGSQL\Request;
    use LFW\ORM\RequestInterface;

    /**
     * Class Select
     * @package LFW\ORM\PGSQL\Request
     */
    class Select implements RequestInterface{
        /**
         * @var string
         */
        private $table = '';

        /**
         * @var string
         */
        private $entity = '';

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
         * @var string
         */
        private $offset = '';

        /**
         * @var string
         */
        private $groupBy = '';

        /**
         * Select constructor.
         * @param array $array
         */
        public function __construct($array){
            $table = $array['table'];
            $this->table = "\"$table\"";
            $this->setEntity($table);

            if(!empty($array['order'])){
                $this->order = 'ORDER BY '.$array['order'];
            }

            if(!empty($array['limit'])){
                $this->limit = 'LIMIT '.$array['limit'];
            }

            if(!empty($array['offset'])){
                $this->offset = 'OFFSET '.$array['offset'];
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
         * @param string $exec
         */
        public function setAddExec($exec){
            $this->arrayWhere[] = $exec;
        }

        /**
         * @param string $col
         * @param string $having
         */
        public function setGroupBy($col, $having = ''){
            $this->groupBy = 'GROUP BY '.$col;
            $this->groupBy .= ($having == '') ? '' : ' HAVING '.$having;
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
                return 'SELECT '.$this->colSel.' FROM '.$this->table.' '.$this->where.' '.$this->groupBy.' '.$this->order.' '.$this->limit.' '.$this->offset;
            }
        }

        /**
         * @return string
         */
        public function getColSel(){
            return $this->colSel;
        }

        /**
         * @return string
         */
        public function getTable(){
            return $this->table;
        }

        /**
         * @return string
         */
        public function getEntity(){
            return $this->entity;
        }

        /**
         * @param string $table
         */
        public function setEntity($table){
            $this->entity = ucfirst($table);
        }
    }