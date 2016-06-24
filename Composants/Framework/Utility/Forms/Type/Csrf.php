<?php
    namespace Composants\Framework\Utility\Forms\Type;

    /**
     * Class Csrf
     * @package Composants\Framework\Utility\Forms\Type
     */
    class Csrf{
        /**
         * @var string
         */
        private $input;

        /**
         * Csrf constructor.
         * @param string $token
         */
        public function __construct($token){
            $this->input = '<input type="hidden" name="token" value="'.$token.'">';
        }

        /**
         * @return string
         */
        public function getInput(){
            return $this->input;
        }
    }