<?php
namespace Frash\Template\Extensions;
use Frash\Template\DependTemplEngine;

/**
 * Class PublicDir
 * @package Frash\Template\Extensions
 */
class PublicDir{
    /**
     * @var DependTemplEngine
     */
    private $dic_t;

    /**
     * @var array
     */
    private $params = [];

    /**
     * PublicDir constructor.
     * @param DependTemplEngine $dic_t
     * @param array $params
     */
    public function __construct(DependTemplEngine $dic_t, array $params){
        $this->dic_t = $dic_t;
        $this->params = $params;
    }

    /**
     * @param string $route
     * @return string
     */
    public function parse(string $route): string{
        $prefix = ($this->params['prefix'] == '/') ? '' : $this->params['prefix'];
        return $prefix.'public/'.$route;
    }
}