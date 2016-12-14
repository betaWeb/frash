<?php
    namespace LFW\Framework\Forms\Type;
    use LFW\Framework\Forms\FormTypeInterface;

    /**
     * Class Radio
     * @package LFW\Framework\Forms\Type
     */
    class Radio implements FormTypeInterface {
        /**
         * @var string
         */
        private $input;

        /**
         * Radio constructor.
         * @param array $spec
         */
        public function __construct($spec){
            $this->input = '<input type="radio"';

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

            if(!empty($spec['required']) && $spec['required'] === true){
                $this->input .= ' required';
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