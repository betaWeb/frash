<?php
    namespace Composants\Framework\Utility\Forms\Type;

    /**
     * Class Submit
     * @package Composants\Framework\Utility\Forms\Type
     */
    class Submit{
        /**
         * @var string
         */
        private $input;

        /**
         * Submit constructor.
         * @param array $spec
         */
        public function __construct($spec){
            $this->input = '<input type="submit"';

            if(!empty($spec['name'])){
                $this->input .= ' name="'.$spec['name'].'"';
            }

            if(!empty($spec['value'])){
                $this->input .= ' value="'.$spec['value'].'"';
            }

            if(!empty($spec['disabled']) && $spec['disabled'] === true){
                $this->input .= ' disabled';
            }

            if(!empty($spec['id'])){
                $this->input .= ' id="'.$spec['id'].'"';
            }

            if(!empty($spec['class'])){
                $this->input .= ' class="'.$spec['class'].'"';
            }

            if(!empty($spec['autofocus'])){
                $this->input .= ' autofocus';
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