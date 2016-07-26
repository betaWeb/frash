<?php
    namespace Composants\Framework\Utility\Forms\Type;

    /**
     * Class Textarea
     * @package Composants\Framework\Utility\Forms\Type
     */
    class Textarea{
        /**
         * @var string
         */
        private $input;

        /**
         * Textarea constructor.
         * @param array $spec
         */
        public function __construct($spec){
            $this->input = '<textarea';

            if(!empty($spec['name'])){
                $this->input .= ' name="'.$spec['name'].'"';
            }

            if(!empty($spec['cols'])){
                $this->input .= ' cols="'.$spec['cols'].'"';
            }

            if(!empty($spec['rows'])){
                $this->input .= ' rows="'.$spec['rows'].'"';
            }

            if(!empty($spec['id'])){
                $this->input .= ' id="'.$spec['id'].'"';
            }

            if(!empty($spec['class'])){
                $this->input .= ' class="'.$spec['class'].'"';
            }

            if(!empty($spec['placeholder'])){
                $this->input .= ' placeholder="'.$spec['placeholder'].'"';
            }

            if(!empty($spec['require']) && $spec['require'] === true){
                $this->input .= ' required';
            }

            $this->input .= '>';

            if(!empty($spec['value'])){
                $this->input .= $spec['value'];
            }

            $this->input .= '</textarea>';
        }

        /**
         * @return string
         */
        public function getInput(){
            return $this->input;
        }
    }