<?php
    namespace Composants\Framework\Forms\Type;
    use Composants\Framework\Forms\FormTypeInterface;

    /**
     * Class Csrf
     * @package Composants\Framework\Forms\Type
     */
    class Csrf implements FormTypeInterface {
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