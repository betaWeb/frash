<?php
namespace Frash\Framework\Request\Session;
use Frash\Framework\DIC\Dic;

/**
 * Class Session
 * @package Frash\Framework\Request\Session
 */
class Session{
    /**
     * @var array
     */
    private $flashbag = [];

    /**
     * @var array
     */
    private $session = [];

    /**
     * Session constructor.
     * @param Dic $dic
     */
    public function __construct(Dic $dic){
        if(empty($this->session) && empty($this->flashbag) && $dic->env != 'console' && !empty($_SESSION)){
            $this->session += $_SESSION;

            if(array_key_exists('flashbag', $this->session)){
                $this->flashbag = $this->session['flashbag'];
            }
        }
    }

    /**
     * @param string $session
     * @return mixed
     */
    public function get(string $session){
        if(array_key_exists($session, $this->session)){
            return $this->session[ $session ];
        }
    }

    /**
     * @param string $session
     * @return boolean
     */
    public function has(string $session): bool{
        if(array_key_exists($session, $this->session)){
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return bool|mixed
     */
    public function flashbag(string $name, $value = ''){
        if($value == ''){
            if(!empty($this->flashbag) && array_key_exists($name, $this->flashbag)){
                return $this->flashbag[ $name ];
            } else {
                return false;
            }
        } else {
            $this->flashbag[ $name ] = $value;
            $_SESSION['flashbag'][ $name ] = $value;

            return $value;
        }
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function set(string $name, $value){
        $this->session[ $name ] = $value;
        $_SESSION[ $name ] = $value;

        return $value;
    }

    /**
     * @param string $session
     */
    public function unset(string $session){
        unset($this->session[ $session ]);
        unset($_SESSION[ $session ]);
    }

    public function unsetAll(){
        $this->session = [];

        session_unset();
        session_destroy();
    }
}