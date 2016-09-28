<?php
    namespace Composants\Framework\Forms\Type;
    use Composants\Framework\Forms\FormTypeInterface;

    /**
     * Class Textarea
     * @package Composants\Framework\Forms\Type
     */
    class Textarea implements FormTypeInterface {
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