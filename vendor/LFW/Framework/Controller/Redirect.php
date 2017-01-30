<?php
namespace LFW\Framework\Controller;
use LFW\Framework\DIC\Dic;

/**
 * Class Redirect
 * @package LFW\Framework\Controller
 */
class Redirect{
    /**
     * @var string
     */
    private $prefix = '';

    /**
     * Redirect constructor.
     * @param Dic $dic
     */
    public function __construct(Dic $dic){
        $this->prefix = (string) $dic->get('prefix_lang');
    }

    /**
     * @param string $url
     * @return bool
     */
    public function route(string $url): bool{
        header('Location:'.$this->prefix.'/'.$url);
        return true;
    }

    /**
     * @param string $url
     * @return bool
     */
    public function url(string $url): bool{
        header('Location:'.$url);
        return true;
    }
}