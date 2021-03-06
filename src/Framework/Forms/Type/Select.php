<?php
namespace Frash\Framework\Forms\Type;

/**
 * Class Select
 * @package Frash\Framework\Forms\Type
 */
class Select{
    /**
     * @var string
     */
    private $input;

    /**
     * Select constructor.
     * @param array $spec
     */
    public function __construct($spec){
        $arr_select = $spec[0];
        $arr_option = $spec[1];

        $this->input = '<select';

        if(!empty($arr_select['name'])){
            $this->input .= ' name="'.$arr_select['name'].'"';
        }

        if(!empty($arr_select['title'])){
            $this->input .= ' title="'.$arr_select['title'].'"';
        }

        if(!empty($arr_select['multiple']) && $arr_select['multiple'] === true){
            $this->input .= ' multiple';
        }

        if(!empty($arr_select['id'])){
            $this->input .= ' id="'.$arr_select['id'].'"';
        }

        if(!empty($arr_select['class'])){
            $this->input .= ' class="'.$arr_select['class'].'"';
        }

        $this->input .= '>';

        foreach($arr_option as $k => $v){
            $this->input .= '<option value="'.$k.'"';

            if(!empty($arr_select['select']) && $k == $arr_select['select']){
                $this->input .= ' selected';
            }

            if(is_array($v)){
                if(!empty($v['disabled']) && $v['disabled'] === true){
                    $this->input .= ' disabled';
                }

                $this->input .= '>'.$v['value'].'</option>';
            } else {
                $this->input .= '>'.$v.'</option>';
            }
        }

        $this->input .= '</select>';
    }

    /**
     * @return string
     */
    public function get(){
        return $this->input;
    }
}