<?php
namespace LFW\Framework\Request;
use LFW\Framework\DIC\Dic;

/**
 * Class Redirect
 * @package LFW\Framework\Request
 */
class Redirect{
    /**
     * @var string
     */
    private $prefix = '';

    /**
     * @var string
     */
    private $url = '';

    /**
     * @var integer
     */
    private $code = 200;

    /**
     * Redirect constructor.
     * @param Dic $dic
     */
    public function __construct(Dic $dic){
        $this->prefix = (string) $dic->get('prefix_lang');
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