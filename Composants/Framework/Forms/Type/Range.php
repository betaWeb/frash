<?php
    namespace Composants\Framework\Forms\Type;
    use Composants\Framework\Forms\FormTypeInterface;

    /**
     * Class Range
     * @package Composants\Framework\Forms\Type
     */
    class Range implements FormTypeInterface {
        /**
         * @var string
         */
        private $input;

        /**
         * Range constructor.
         * @param array $spec
         */
        public function __construct($spec){
            $this->input = '<input type="range"';

            if(!empty($spec['name'])){
                $this->input .= ' name="'.$spec['name'].'"';
            }

            if(!empty($spec['value'])){
                $this->input .= ' value="'.$spec['value'].'"';
            }

            if(!empty($spec['max'])){
                $this->input .= ' max="'.$spec['max'].'"';
            }

            if(!empty($spec['min'])){
                $this->input .= ' min="'.$spec['min'].'"';
            }

            if(!empty($spec['step'])){
                $this->input .= ' step="'.$spec['step'].'"';
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