<?php
    namespace Composants\Framework\Forms;

    /**
     * Class CreateForm
     * @package Composants\Framework\Forms
     */
    class CreateForm{
        /**
         * @param $array
         * @return string
         */
        public function startForm($array){
            $stringForm = '<form';

            if(!empty($array['method'])){
                $stringForm .= ' method="'.$array['method'].'"';
            }

            if(!empty($array['action'])){
                $stringForm .= ' action="'.$array['action'].'"';
            }

            $stringForm .= '>';

            return $stringForm;
        }

        /**
         * @return string
         */
        public function endForm(){
            return '</form>';
        }

        /**
         * @param $array
         * @return string
         */
        public function addInput($array){
            $stringForm = '<input';

            if(!empty($array['name'])){
                $stringForm .= ' name="'.$array['name'].'"';
            }

            if(!empty($array['type'])){
                $stringForm .= ' type="'.$array['type'].'"';
            }

            if(!empty($array['value'])){
                $stringForm .= ' value="'.$array['value'].'"';
            }

            if(!empty($array['placeholder'])){
                $stringForm .= ' placeholder="'.$array['placeholder'].'"';
            }

            if(!empty($array['require']) && $array['require'] === true){
                $stringForm .= ' required';
            }

            if(!empty($array['autocomp']) && $array['autocomp'] === false){
                $stringForm .= ' autocomplete="off"';
            }

            if(!empty($array['idcss'])){
                $stringForm .= ' id="'.$array['idcss'].'"';
            }

            if(!empty($array['classcss'])){
                $stringForm .= ' class="'.$array['classcss'].'"';
            }

            $stringForm .= '>';

            return $stringForm;
        }

        /**
         * @param $array
         * @return string
         */
        public function addTextarea($array){
            $stringForm = '<textarea';

            if(!empty($array['name'])){
                $stringForm .= ' name="'.$array['name'].'"';
            }

            if(!empty($array['cols'])){
                $stringForm .= ' cols="'.$array['cols'].'"';
            }

            if(!empty($array['rows'])){
                $stringForm .= ' rows="'.$array['rows'].'"';
            }

            if(!empty($array['idcss'])){
                $stringForm .= ' id="'.$array['idcss'].'"';
            }

            if(!empty($array['classcss'])){
                $stringForm .= ' class="'.$array['classcss'].'"';
            }

            $stringForm .= '>';

            if(!empty($array['value'])){
                $stringForm .= $array['value'];
            }

            $stringForm .= '</textarea>';

            return $stringForm;
        }

        /**
         * @param $arr_select
         * @param $arr_option
         * @return string
         */
        public function addSelectOption($arr_select, $arr_option){
            $stringForm = '<select';

            if(!empty($arr_select['name'])){
                $stringForm .= ' name="'.$arr_select['name'].'"';
            }

            $stringForm .= '>';

            foreach($arr_option as $k => $v){
                $stringForm .= '<option value="'.$k.'"';

                if(!empty($arr_select['select']) && $k == $arr_select['select']){
                    $stringForm .= ' selected';
                }

                $stringForm .= '>'.$v.'</option>';
            }

            $stringForm .= '</select>';

            return $stringForm;
        }

        /**
         * @param $array
         * @return string
         */
        public function addInputRange($array){
            $stringForm = '<input type="range"';

            if(!empty($array['name'])){
                $stringForm .= ' name="'.$array['name'].'"';
            }

            if(!empty($array['value'])){
                $stringForm .= ' value="'.$array['value'].'"';
            }

            if(!empty($array['max'])){
                $stringForm .= ' max="'.$array['max'].'"';
            }

            if(!empty($array['min'])){
                $stringForm .= ' min="'.$array['min'].'"';
            }

            if(!empty($array['step'])){
                $stringForm .= ' step="'.$array['step'].'"';
            }

            if(!empty($array['idcss'])){
                $stringForm .= ' id="'.$array['idcss'].'"';
            }

            if(!empty($array['classcss'])){
                $stringForm .= ' class="'.$array['classcss'].'"';
            }

            $stringForm .= '>';

            return $stringForm;
        }
    }