<?php
    namespace LFW\Framework\Forms;

    /**
     * Class CreateForm
     * @package LFW\Framework\Forms
     */
    class CreateForm{
        /**
         * @var string
         */
        private $path = '';

        /**
         * CreateForm constructor.
         * @param string $path
         */
        public function __construct($path){
            $this->path = $path;
        }

        /**
         * @param string $type_form
         * @param array $spec
         * @return string
         */
        public function create($type_form, $spec){
            $routing = $this->path.$type_form;
            $type = new $routing($spec);
            return $type->getInput();
        }
    }