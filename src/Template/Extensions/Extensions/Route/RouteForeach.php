<?php
namespace Frash\Template\Extensions\Extensions\Route;
use Frash\Template\DependTemplEngine;
use Frash\Template\Extensions\Extend\ExtensionParseForeach;

/**
 * Class RouteForeach
 * @package Frash\Template\Extensions\Extensions\Route
 */
class RouteForeach extends ExtensionParseForeach{
    /**
     * @var DependTemplEngine
     */
    private $dic_t;

    /**
     * @var array
     */
    private $params = [];

    /**
     * RouteForeach constructor.
     * @param DependTemplEngine $dic_t
     * @param array $params
     */
    public function __construct(DependTemplEngine $dic_t, array $params){
        $this->dic_t = $dic_t;
        $this->params = $params;
    }

    public function parse(){
        $route = $this->infos['params']['match'][3];
        $road = explode('/', $route);

        foreach($road as $r){
            if(!empty($r) && $r[0] == '@'){
                $route = str_replace($r, $this->dic_t->extension('ShowVar')->parse(ltrim($r, '@')), $route);
            } elseif(!empty($r) && $r[0] == '!') {
                $ext = $this->dic_t->callExtension()->parseForeach('ShowVarParseForeach', 'route', $this->infos, [ 'match' => ltrim($r, '!'), 'params_foreach' => [ 'k' => $this->infos['params']['params_foreach']['k'], 'v' => $this->infos['params']['params_foreach']['v'] ] ])->getInfos()['content'];

                $route = str_replace($r, $ext, $route);
            }
        }

        $this->infos['content'] = $this->params['prefix_lang'].'/'.$route;
    }
}