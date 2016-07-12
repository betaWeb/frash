<?php
    namespace Composants\Framework\Utility\Forms\Type;

    /**
     * Class Color
     * @package Composants\Framework\Utility\Forms\Type
     */
    class Color{
        /**
         * @var string
         */
        private $input;

        /**
         * Color constructor.
         * @param array $spec
         */
        public function __construct($spec){
            $this->input = '<input type="color"';

            if(!empty($spec['name'])){
                $this->input .= ' name="'.$spec['name'].'"';
            }

            if(!empty($spec['value'])){
                $this->input .= ' value="'.$spec['value'].'"';
            }

            if(!empty($spec['id'])){
                $this->input .= ' id="'.$spec['id'].'"';
            }

            if(!empty($spec['class'])){
                $this->input .= ' class="'.$spec['class'].'"';
            }

            $this->input .= '>';
        }

        /**
         * @return string
         */
        public function getInput(){
            return $this->input;
        }
    }