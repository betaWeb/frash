<?php
namespace Frash\Framework\Forms;
use Frash\Framework\DIC\Dic;

/**
 * Class VerifForm
 * @package Frash\Framework\Forms
 */
class VerifForm{
    /**
     * @var Dic
     */
    private $dic;

    /**
     * VerifForm constructor.
     * @param Dic $dic
     */
    public function __construct(Dic $dic){
        $this->dic = $dic;
    }

    /**
     * @param string $csrf
     * @param string $name
     * @return bool
     */
    public function csrf($csrf, string $name){
        if($csrf != ''){
            return ($this->dic->get($name) == $csrf) ? true : false;
        }
    }

    /**
     * @param string $mail
     * @return bool
     */
    public function isMail($mail){
        return (filter_var($mail, FILTER_VALIDATE_EMAIL)) ? true : false;
    }
}