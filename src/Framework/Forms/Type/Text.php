<?php
namespace Frash\Framework\Forms\Type;
use Frash\Framework\Forms\FormTypeInterface;

/**
 * Class Text
 * @package Frash\Framework\Forms\Type
 */
class Text implements FormTypeInterface {
    /**
     * @var string
     */
    private $input;

    /**
     * Text constructor.
     * @param array $spec
     */
    public function __construct($spec){
        $this->input = '<input';

        if(!empty($spec['name'])){
            $this->input .= ' name="'.$spec['name'].'"';
        }

        if(!empty($spec['value'])){
            $this->input .= ' value="'.$spec['value'].'"';
        }

        if(!empty($spec['placeholder'])){
            $this->input .= ' placeholder="'.$spec['placeholder'].'"';
        }

        if(!empty($spec['maxlen'])){
            $this->input .= ' maxlength="'.$spec['maxlen'].'"';
        }

        if(!empty($spec['size'])){
            $this->input .= ' size="'.$spec['size'].'"';
        }

        if(!empty($spec['require']) && $spec['require'] === true){
            $this->input .= ' required';
        }

        if(!empty($spec['autocomp']) && $spec['autocomp'] === false){
            $this->input .= ' autocomplete="off"';
        }

        if(!empty($spec['disabled']) && $spec['disabled'] === true){
            $this->input .= ' disabled';
        }

        if(!empty($spec['pattern'])){
            $this->input .= ' pattern="'.$spec['pattern'].'"';
        }

        if(!empty($spec['id'])){
            $this->input .= ' id="'.$spec['id'].'"';
        }

        if(!empty($spec['class'])){
            $this->input .= ' class="'.$spec['class'].'"';
        }

        if(!empty($spec['autofocus'])){
            $this->input .= ' autofocus';
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