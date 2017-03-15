<?php
namespace Frash\Template\Extensions\Extensions\Route;
use Frash\Template\DependTemplEngine;
use Frash\Template\Extensions\Extend\ExtensionParseSimple;

/**
 * Class Route
 * @package Frash\Template\Extensions\Extensions\Route
 */
class Route extends ExtensionParseSimple{
    /**
     * @var DependTemplEngine
     */
    private $dic_t;

    /**
     * @var array
     */
    private $params = [];

    /**
     * Route constructor.
     * @param DependTemplEngine $dic_t
     * @param array $params
     */
    public function __construct(DependTemplEngine $dic_t, array $params){
        $this->dic_t = $dic_t;
        $this->params = $params;
    }

    public function parse(){
        if($this->infos['level']['foreach'] == 0){
            $route = $this->infos['params']['match'][3];
            $road = explode('/', $route);

            foreach($road as $r){
                if(!empty($r) && $r[0] == '@'){
                    $route = str_replace($r, $this->dic_t->extension('ShowVar')->parse(ltrim($r, '@')), $route);
                }
            }

            $this->infos['tpl'] = str_replace($this->infos['params']['match'][0], $this->params['prefix_lang'].'/'.$route, $this->infos['tpl']);
        }
    }
}