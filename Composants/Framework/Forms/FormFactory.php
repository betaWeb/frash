<?php
    namespace Composants\Framework\Forms;
    use Composants\Framework\Forms\VerifForm;
    use Composants\Framework\Forms\CreateForm;

    /**
     * Class FormFactory
     * @package Composants\Framework\Forms
     */
    class FormFactory{
        /**
         * @return \Composants\Framework\Forms\VerifForm
         */
        public function verif(){
            return new VerifForm;
        }

        /**
         * @param string $uri
         * @return \Composants\Framework\Forms\CreateForm
         */
        public function create($uri){
            return new CreateForm($uri);
        }
    }