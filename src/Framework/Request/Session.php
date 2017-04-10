<?php
namespace Frash\Framework\Request;
use Frash\Framework\DIC\Dic;

/**
 * Class Session
 * @package Frash\Framework\Request
 */
class Session{
    /**
     * @var array
     */
    private $session = [];

    /**
     * Session constructor.
     * @param Dic $dic
     */
    public function __construct(Dic $dic){
        if(empty($this->session) && empty($this->flashbag)){
            foreach($_SESSION as $session => $val){
                if($session == 'flashbag'){
                    foreach($val as $sess => $val_flash){
                        $this->session['flashbag'][ $sess ] = $val_flash;
                    }
                } else {
                    $this->session[ $session ] = $val;
                }
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
            if(!empty($this->session['flashbag']) && array_key_exists($name, $this->session['flashbag'])){
                return $this->session['flashbag'][ $name ];
            } else {
                return false;
            }
        } else {
            $this->session['flashbag'][ $name ] = $value;
            $_SESSION['flashbag'][ $name ] = $value;

            return $value;
        }
    }

    /**
     * @return array
     */
    public function list_flashbag(): array{
        if(!empty($this->session['flashbag'])){
            $flashbags = $this->session['flashbag'];
            $this->unset('flashbag');

            return $flashbags;
        } else {
            return [];
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