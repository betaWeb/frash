<?php
    namespace Composants\Framework\Forms;
    use Composants\Framework\DIC\Dic;

    /**
     * Class CreateFormSql
     * @package Composants\Framework\Forms
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