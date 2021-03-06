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
            return ($this->dic->load('session')->flashbag($name) == $csrf) ? true : false;
        }
    }

    /**
     * @param string $mail
     * @return bool
     */
    public function isMail(string $mail): bool{
        return (filter_var($mail, FILTER_VALIDATE_EMAIL)) ? true : false;
    }

    /**
     * @param mixed $content
     * @param string $regex
     * @return boolean
     */
    public function isRegex($content, string $regex): bool{
        return (preg_match($regex, $content)) ? true : false;
    }

    /**
     * @param mixed $param
     * @return bool
     */
    public function isString($param): bool{
        return is_string($param);
    }
}