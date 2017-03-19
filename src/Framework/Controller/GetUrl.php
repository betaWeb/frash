<?php
namespace Frash\Framework\Controller;
use Frash\Framework\DIC\Dic;

/**
 * Class GetUrl
 * @package Frash\Framework\Controller
 */
class GetUrl{
    private $prefix = '';

    /**
     * @param Dic $dic
     */
    public function __construct(Dic $dic){
        $this->prefix = $dic->prefix_lang;
    }

    /**
     * @param string $url
     * @param string $uri
     * @return string
     */
    public function url(string $url): string{
        return $this->prefix.'/'.$url;
    }
}