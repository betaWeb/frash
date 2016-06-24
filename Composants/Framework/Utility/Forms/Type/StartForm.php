<?php
    namespace Composants\Framework\Utility\Forms\Type;

    /**
     * Class StartForm
     * @package Composants\Framework\Utility\Forms\Type
     */
    class StartForm{
        /**
         * @var string
         */
        private $input;

        /**
         * StartForm constructor.
         * @param array $spec
         */
        public function __construct($spec){
            $this->input = '<form';

            if(!empty($spec['method'])){
                $this->input .= ' method="'.$spec['method'].'"';
            }

            if(!empty($spec['action'])){
                $this->input .= ' action="'.$spec['action'].'"';
            }

            if(!empty($spec['id'])){
                $this->input .= ' id="'.$spec['id'].'"';
            }

            if(!empty($spec['class'])){
                $this->input .= ' class="'.$spec['class'].'"';
            }

            if(!empty($spec['title'])){
                $this->input .= ' title="'.$spec['title'].'"';
            }

            if(!empty($spec['enctype'])){
                $this->input .= ' enctype="'.$spec['enctype'].'"';
            }

            if(!empty($spec['dir'])){
                $this->input .= ' dir="'.$spec['dir'].'"';
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