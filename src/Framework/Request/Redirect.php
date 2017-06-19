<?php
namespace Frash\Framework\Request;
use Frash\Framework\DIC\Dic;

/**
 * Class Redirect
 * @package Frash\Framework\Request
 */
class Redirect{
    /**
     * @var integer
     */
    private $code = 200;

    /**
     * @var Dic
     */
    private $dic;

    /**
     * @var string
     */
    private $prefix = '';

    /**
     * @var Session
     */
    private $session;

    /**
     * @var string
     */
    private $url = '';

    /**
     * Redirect constructor.
     * @param Dic $dic
     */
    public function __construct(Dic $dic){
        $this->dic = $dic;
        $this->session = $this->dic->load('session');
        $this->prefix = (string) $this->dic->prefix_lang;
    }

    public function back(){
        $config = $this->dic->config;

        if(!empty($config['stock_route']) && $config['stock_route'] == 'yes'){
            $this->url = $this->session->get('frash_before_url');
        }

        return $this;
    }

    /**
     * @param int $code
     * @return object
     */
    public function code(int $code){
        $this->code = $code;
        return $this;
    }

    /**
     * @param string $url
     * @return object
     */
    public function route(string $url){
        $this->url = $this->prefix.'/'.$url;
        return $this;
    }

    /**
     * @param string $url
     * @return object
     */
    public function url(string $url){
        $this->url = $url;
        return $this;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return object
     */
    public function with(string $key, $value){
        $this->session->flashbag($key, $value);
        return $this;
    }

    /**
     * @return bool
     */
    public function go(): bool{
        if($this->code == 200){
            header('Location:'.$this->url);
        } else {
            header('Location:'.$this->url, true, $this->code);
        }

        return true;
    }
}