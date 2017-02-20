<?php
namespace LFW\Framework\Forms\Type;
use LFW\Framework\Forms\FormTypeInterface;

/**
 * Class Hidden
 * @package LFW\Framework\Forms\Type
 */
class Hidden implements FormTypeInterface {
    /**
     * @var string
     */
    private $input;

    /**
     * Hidden constructor.
     * @param array $spec
     */
    public function __construct($spec){
        $this->input = '<input type="hidden"';

        if(!empty($spec['name'])){
            $this->input .= ' name="'.$spec['name'].'"';
        }

        if(!empty($spec['value'])){
            $this->input .= ' value="'.$spec['value'].'"';
        }

        if(!empty($spec['maxlen'])){
            $this->input .= ' maxlength="'.$spec['maxlen'].'"';
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

        $this->input .= '>';
    }

    /**
     * @return string
     */
    public function getInput(){
        return $this->input;
    }
}