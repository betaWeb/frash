<?php
namespace LFW\Framework\Request;

/**
 * Class Session
 * @package LFW\Framework\Request
 */
class Session{
    /**
     * @var array
     */
    private $session_name = [];

    /**
     * @var array
     */
    private $session_value = [];

    /**
     * Session constructor.
     */
    public function __construct(){
        if(empty($this->session_name) && empty($this->session_value)){
            foreach($_SESSION as $session => $val){
                $this->session_name[] = $session;
                $this->session_value[ $session ] = $val;
            }
        }
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function setSession(string $name, $value){
        if(!array_key_exists($name, $this->session_value)){
            $this->session_name[] = $name;
        }

        $this->session_value[ $name ] = $value;
        $_SESSION[ $name ] = $value;

        return $value;
    }

    /**
     * @param string $session
     * @return bool|mixed
     */
    public function getSession(string $session){
        if(in_array($session, $this->session_name)){
            return $this->session_value[ $session ];
        } else {
            return false;
        }
    }

    /**
     * @param string $session
     */
    public function unsetSession(string $session){
        $key = array_search($session, $this->session_name);
        unset($this->session_name[ $key ]);
        unset($this->session_value[ $key ]);
    }

    public function unsetAllSession(){
        $this->session_name = [];
        $this->session_value = [];

        session_unset();
        session_destroy();
    }
}