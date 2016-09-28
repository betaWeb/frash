<?php
    namespace Composants\Framework\Forms;

    /**
     * Class CreateForm
     * @package Composants\Framework\Forms
     */
    class CreateForm{
        const PATH = 'Composants\\Framework\\Forms\\Type\\';

        /**
         * @var string
         */
        private $uri = '';

        /**
         * CreateForm constructor.
         * @param string $uri
         */
        public function __construct($uri = ''){
            $this->uri = $uri;
        }

        /**
         * @param string $type_form
         * @param array $spec
         * @return string
         */
        public function create($type_form, $spec){
            $routing = self::PATH.$type_form;
            $type = new $routing($spec, $this->uri);
            return $type->getInput();
        }
    }