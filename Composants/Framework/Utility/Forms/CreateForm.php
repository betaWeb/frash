<?php
    namespace Composants\Framework\Utility\Forms;

    /**
     * Class CreateForm
     * @package Composants\Framework\Utility\Forms
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

            if(!empty($array['idcss'])){
                $stringForm .= ' id="'.$array['idcss'].'"';
            }

            if(!empty($array['classcss'])){
                $stringForm .= ' class="'.$array['classcss'].'"';
            }

            if(!empty($array['title'])){
                $stringForm .= ' title="'.$array['title'].'"';
            }

            if(!empty($array['enctype'])){
                $stringForm .= ' enctype="'.$array['enctype'].'"';
            }

            if(!empty($array['dir'])){
                $stringForm .= ' dir="'.$array['dir'].'"';
            }

            return $stringForm.'>';
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

            if(!empty($array['maxlen'])){
                $stringForm .= ' maxlength="'.$array['maxlen'].'"';
            }

            if(!empty($array['size'])){
                $stringForm .= ' size="'.$array['size'].'"';
            }

            if(!empty($array['require']) && $array['require'] === true){
                $stringForm .= ' required';
            }

            if(!empty($array['autocomp']) && $array['autocomp'] === false){
                $stringForm .= ' autocomplete="off"';
            }

            if(!empty($array['disabled']) && $array['disabled'] === true){
                $stringForm .= ' disabled';
            }

            if(!empty($array['pattern'])){
                $stringForm .= ' pattern="'.$array['pattern'].'"';
            }

            if(!empty($array['idcss'])){
                $stringForm .= ' id="'.$array['idcss'].'"';
            }

            if(!empty($array['classcss'])){
                $stringForm .= ' class="'.$array['classcss'].'"';
            }

            if(!empty($array['autofocus'])){
                $stringForm .= ' autofocus';
            }

            return $stringForm.'>';
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

            return $stringForm.'</textarea>';
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

            if(!empty($arr_select['multiple']) && $arr_select['multiple'] === true){
                $stringForm .= ' multiple';
            }

            if(!empty($arr_select['idcss'])){
                $stringForm .= ' id="'.$arr_select['idcss'].'"';
            }

            if(!empty($arr_select['classcss'])){
                $stringForm .= ' class="'.$arr_select['classcss'].'"';
            }

            $stringForm .= '>';

            foreach($arr_option as $k => $v){
                $stringForm .= '<option value="'.$k.'"';

                if(!empty($arr_select['select']) && $k == $arr_select['select']){
                    $stringForm .= ' selected';
                }

                $stringForm .= '>'.$v.'</option>';
            }

            return $stringForm.'</select>';
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

            return $stringForm.'>';
        }

        /**
         * @param $array
         * @return string
         */
        public function addInputFile($array){
            $stringForm = '<input type="file"';

            if(!empty($array['name'])){
                $stringForm .= ' name="'.$array['name'].'"';
            }

            if(!empty($array['multiple']) && $array['multiple'] === true){
                $stringForm .= ' multiple';
            }

            if(!empty($array['idcss'])){
                $stringForm .= ' id="'.$array['idcss'].'"';
            }

            if(!empty($array['classcss'])){
                $stringForm .= ' class="'.$array['classcss'].'"';
            }

            return $stringForm.'>';
        }

        /**
         * @param $array
         * @return string
         */
        public function addCheckbox($array){
            $stringForm = '<input type="checkbox"';

            if(!empty($array['name'])){
                $stringForm .= ' name="'.$array['name'].'"';
            }

            if(!empty($array['value'])){
                $stringForm .= ' value="'.$array['value'].'"';
            }

            if(!empty($array['idcss'])){
                $stringForm .= ' id="'.$array['idcss'].'"';
            }

            if(!empty($array['classcss'])){
                $stringForm .= ' class="'.$array['classcss'].'"';
            }

            return $stringForm.'>';
        }
    }