<?php
namespace Frash\Template\Extensions\Extensions\Bundle;
use Frash\Template\DependTemplEngine;
use Frash\Template\Extensions\Extend\ExtensionParseSimple;

/**
 * Class BundleParse
 * @package Frash\Template\Extensions\Extensions\Bundle
 */
class BundleParse extends ExtensionParseSimple{
    /**
     * @var array
     */
    private $params = [];

    /**
     * BundleParse constructor.
     * @param DependTemplEngine $dic_t
     * @param array $params
     */
    public function __construct(DependTemplEngine $dic_t, array $params){
        $this->params = $params;
    }

    public function parse(){
        if($this->infos['level']['foreach'] == 0){
            if(strstr($this->infos['params']['match'][3], '::')){
                list($bundle, $file) = explode('::', $this->infos['params']['match'][3]);
            } else {
                $bundle = $this->infos['bundle'];
                $file = $this->infos['params']['match'][3];
            }

            $prefix = ($this->params['prefix'] == '/') ? '' : $this->params['prefix'];
            $this->infos['tpl'] = str_replace($this->infos['params']['match'][0], $prefix.'Bundles/'.$bundle.'/Ressources/'.rtrim($file), $this->infos['tpl']);
        }
    }
}