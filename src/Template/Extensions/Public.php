<?php
namespace LFW\Template\Extensions;
use LFW\Template\DependTemplEngine;

/**
 * Class Public
 * @package LFW\Template\Extensions
 */
class Public{
    /**
     * @var DependTemplEngine
     */
    private $dic_t;

    /**
     * @var array
     */
    private $params = [];

    /**
     * Public constructor.
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
        if(strstr($route, '/')){
            $road = explode('/', $route);
            foreach($road as $r){
                if(!empty($r) && $r[0] == '@'){
                    $route = str_replace($r, $this->dic_t->load('ShowVar')->parse(ltrim($r, '@')), $route);
                } elseif(!empty($r) && $r[0] == '!') {
                    $route = str_replace($r, $this->dic_t->load('FormatVar')->parseRouteForeach(ltrim($r, '!')), $route);
                }
            }
        } else {
            if($route[0] == '@'){
                $route = str_replace($route, $this->dic_t->load('ShowVar')->parse(ltrim($route, '@')), $route);
            } elseif($route[0] == '!') {
                $route = str_replace($route, $this->dic_t->load('ShowVar')->parse(ltrim($route, '!')), $route);
            }
        }

        return $this->params['prefix_lang'].'/'.$route;
    }
}