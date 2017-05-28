<?php
namespace Frash\Framework\Forms\Type;

/**
 * Class Input
 * @package Frash\Framework\Forms\Type
 */
class Input{
    /**
     * @param string $type
     * @param array $params
     * @return string
     */
    public function input(string $type, array $params){
        $input = '<input type="'.$type.'"';

        if(!empty($params['name'])){
            $input .= ' name="'.$params['name'].'"';
        }

        if(!empty($params['title'])){
            $input .= ' title="'.$params['title'].'"';
        }

        if(!empty($params['value'])){
            $input .= ' value="'.$params['value'].'"';
        }

        if(!empty($params['placeholder'])){
            $input .= ' placeholder="'.$params['placeholder'].'"';
        }

        if(!empty($params['maxlen'])){
            $input .= ' maxlength="'.$params['maxlen'].'"';
        }

        if(!empty($params['size'])){
            $input .= ' size="'.$params['size'].'"';
        }

        if(!empty($params['require']) && $params['require'] === true){
            $input .= ' required';
        }

        if(!empty($params['autocomp']) && $params['autocomp'] === false){
            $input .= ' autocomplete="off"';
        }

        if(!empty($params['disabled']) && $params['disabled'] === true){
            $input .= ' disabled';
        }

        if(!empty($params['pattern'])){
            $input .= ' pattern="'.$params['pattern'].'"';
        }

        if(!empty($params['id'])){
            $input .= ' id="'.$params['id'].'"';
        }

        if(!empty($params['class'])){
            $input .= ' class="'.$params['class'].'"';
        }

        if(!empty($params['autofocus'])){
            $input .= ' autofocus';
        }

        if(!empty($params['min'])){
            $input .= ' min="'.$params['min'].'"';
        }

        if(!empty($params['max'])){
            $input .= ' max="'.$params['max'].'"';
        }

        if(!empty($params['step'])){
            $input .= ' step="'.$params['step'].'"';
        }

        if(!empty($params['multiple']) && $params['multiple'] === true){
            $input .= ' multiple';
        }

        $input .= '>';

        return $input;
    }
}