<?php
namespace LFW\Framework\Forms\Type;
use LFW\Framework\Forms\FormTypeInterface;

/**
 * Class Csrf
 * @package LFW\Framework\Forms\Type
 */
class Csrf implements FormTypeInterface {
    /**
     * @var string
     */
    private $input;

    /**
     * Csrf constructor.
     * @param string $spec
     */
    public function __construct($spec){
        $this->input = '<input type="hidden" name="'.$spec['name'].'" value="'.$spec['session'].'">';
    }

    /**
     * @return string
     */
    public function getInput(){
        return $this->input;
    }
}