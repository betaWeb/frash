<?php
    namespace LFW\Framework\Forms\Type;
    use LFW\Framework\Forms\FormTypeInterface;

    /**
     * Class Date
     * @package LFW\Framework\Forms\Type
     */
    class Date implements FormTypeInterface {
        /**
         * @var string
         */
        private $input;

        /**
         * Color constructor.
         * @param array $spec
         */
        public function __construct($spec){
            $this->input = '<input type="date"';

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