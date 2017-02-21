<?php
namespace Frash\Framework\Forms\Type;
use Frash\Framework\Forms\FormTypeInterface;

/**
 * Class File
 * @package Frash\Framework\Forms\Type
 */
class File implements FormTypeInterface {
    /**
     * @var string
     */
    private $input;

    /**
     * File constructor.
     * @param array $spec
     */
    public function __construct($spec){
        $this->input = '<input type="file"';

        if(!empty($spec['name'])){
            $this->input .= ' name="'.$spec['name'].'"';
        }

        if(!empty($spec['multiple']) && $spec['multiple'] === true){
            $this->input .= ' multiple';
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