<?php
namespace Frash\Framework\Forms\Type;
use Frash\Framework\Forms\FormTypeInterface;

/**
 * Class Csrf
 * @package Frash\Framework\Forms\Type
 */
class Csrf implements FormTypeInterface {
    /**
     * @var string
     */
    private $input;

    /**
     * Csrf constructor.
     * @param array $spec
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