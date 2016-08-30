<?php
    namespace Composants\Framework\Utility\Forms;
    use Composants\Framework\Utility\Forms\VerifForm;
    use Composants\Framework\Utility\Forms\CreateForm;

    /**
     * Class FormFactory
     * @package Composants\Framework\Utility\Forms
     */
    class FormFactory{
        /**
         * @return \Composants\Framework\Utility\Forms\VerifForm
         */
        public function verif(){
            return new VerifForm;
        }

        /**
         * @return \Composants\Framework\Utility\Forms\CreateForm
         */
        public function create(){
            return new CreateForm;
        }
    }