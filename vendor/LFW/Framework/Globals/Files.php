<?php
namespace LFW\Framework\Globals;

/**
 * Class Files
 * @package LFW\Framework\Globals
 */
class Files{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $tmp;

    /**
     * @var string
     */
    private $error;

    /**
     * @var int
     */
    private $size;

    /**
     * Files constructor.
     * @param array $file
     */
    public function __construct($file){
        $this->name = $_FILES[ $file ]['name'];
        $this->type = $_FILES[ $file ]['type'];
        $this->tmp = $_FILES[ $file ]['tmp_name'];
        $this->error = $_FILES[ $file ]['error'];
        $this->size = $_FILES[ $file ]['size'];
    }

    /**
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType(){
        return $this->type;
    }

    /**
     * @return string
     */
    public function getTmp(){
        return $this->tmp;
    }

    /**
     * @return string
     */
    public function getError(){
        return $this->error;
    }

    /**
     * @return int
     */
    public function getSize(){
        return $this->size;
    }
}