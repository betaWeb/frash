<?php
namespace Frash\Template\Extensions\Extensions\Bundle;
use Frash\Template\DependTemplEngine;
use Frash\Template\Extensions\Extend\ExtensionParseTplParent;

/**
 * Class BundleTplParent
 * @package Frash\Template\Extensions
 */
class BundleTplParent extends ExtensionParseTplParent{
    /**
     * @var array
     */
    private $params = [];

    /**
     * BundleTplParent constructor.
     * @param DependTemplEngine $dic_t
     * @param array $params
     */
    public function __construct(DependTemplEngine $dic_t, array $params){
        $this->params = $params;
    }

    public function parse(){
        if($this->infos['level']['foreach'] == 0){
            if(strstr($this->infos['params']['match'][4], '::')){
                list($bundle, $file) = explode('::', $this->infos['params']['match'][4]);
            } else {
                $bundle = $this->infos['bundle'];
                $file = $this->infos['params']['match'][4];
            }

            $prefix = ($this->params['prefix'] == '/') ? '' : $this->params['prefix'];
            $this->infos['tpl'] = str_replace($this->infos['params']['match'][0], $prefix.'Bundles/'.$bundle.'/Ressources/'.$file, $this->infos['tpl']);
        }
    }
}