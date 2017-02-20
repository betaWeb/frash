<?php
namespace LFW\Framework\Forms\Type;
use LFW\Framework\Forms\FormTypeInterface;

/**
 * Class Color
 * @package LFW\Framework\Forms\Type
 */
class Color implements FormTypeInterface {
    /**
     * @var string
     */
    private $input;

    /**
     * Color constructor.
     * @param array $spec
     */
    public function __construct($spec){
        $this->input = '<input type="color"';

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

        $this->input .= '>';
    }

    /**
     * @return string
     */
    public function getInput(){
        return $this->input;
    }
}