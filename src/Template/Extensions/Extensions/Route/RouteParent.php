<?php
namespace Frash\Template\Extensions\Extensions\Route;
use Frash\Template\DependTemplEngine;
use Frash\Template\Extensions\Extend\ExtensionParseParent;

/**
 * Class RouteParent
 * @package Frash\Template\Extensions\Extensions\Route
 */
class RouteParent extends ExtensionParseParent{
    /**
     * @var DependTemplEngine
     */
    private $dic_t;

    /**
     * @var array
     */
    private $params = [];

    /**
     * RouteParent constructor.
     * @param DependTemplEngine $dic_t
     * @param array $params
     */
    public function __construct(DependTemplEngine $dic_t, array $params){
        $this->dic_t = $dic_t;
        $this->params = $params;
    }

    public function parse(){
        if($this->infos['level']['foreach'] == 0){
            $route = rtrim($this->infos['params']['match'][3]);
            $with_lang = true;

            if(strstr($route, ' ')){
                $route = explode(' ', $route)[1];
                $with_lang = false;
            }

            $road = explode('/', $route);

            foreach($road as $r){
                if(!empty($r) && $r[0] == '$'){
                    $route = str_replace($r, $this->dic_t->extension('ShowVar')->parse(ltrim($r, '$')), $route);
                }
            }

            $prefix = ($with_lang) ? $this->params['prefix_lang'] : rtrim($this->params['prefix'], '/');
            $this->infos['tpl'] = str_replace($this->infos['params']['match'][0], $prefix.'/'.$route, $this->infos['tpl']);
        }
    }
}