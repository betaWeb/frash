<?php
    namespace LFW\Framework\Forms;
    use LFW\Framework\DIC\Dic;

    /**
     * Class CreateFormSql
     * @package LFW\Framework\Forms
     */
    class CreateFormSql{
        /**
         * @var string
         */
        private $path = '';

        /**
         * CreateFormSql constructor.
         * @param string $path
         */
        public function __construct($path){
            $this->path = $path;
        }

        /**
         * @param Dic $dic
         * @param array $spec
         */
        public function create(Dic $dic, $spec = []){}
    }