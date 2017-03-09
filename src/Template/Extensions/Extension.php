<?php
namespace Frash\Template\Extensions;
use Frash\Template\Parsing\ParseParent;

/**
 * Class Extension
 * @package Frash\Template\Extensions
 */
class Extension{
    /**
     * @var array
     */
    protected $infos = [];

    /**
     * @param array $attributes
     * @param array $match_all
     * @param int $key
     * @param ParseParent $pp
     */
    public function setInfos(array $attributes, array $match_all, int $key, array $opt = []){
        $this->infos['bundle'] = $attributes['bundle'];
        $this->infos['class_cache'] = $attributes['class_cache'];
        $this->infos['condition'] = $attributes['condition'];
        $this->infos['display'] = (!empty($attributes['display'])) ? $attributes['display'] : '';
        $this->infos['foreach'] = $attributes['foreach'];
        $this->infos['function'] = $attributes['function'];
        $this->infos['incl_parent'] = $attributes['incl_parent'];
        $this->infos['key'] = $key;
        $this->infos['level'] = $attributes['level'];
        $this->infos['match_all'] = $match_all;
        $this->infos['parts'] = $attributes['parts'];
        $this->infos['parts_in_escape'] = $attributes['parts_in_escape'];
        $this->infos['tpl'] = $attributes['tpl'];

        if(!empty($opt['pp'])){
            $this->infos['parse_parent'] = $opt['pp'];
        }

        if(!empty($opt['parsing'])){
            $this->infos['parsing'] = $opt['parsing'];
        }

        if(!empty($opt['params_foreach'])){
            $this->infos['params_foreach'] = $opt['params_foreach'];
        }
    }

    /**
     * @return array
     */
    public function getInfos(): array{
        return $this->infos;
    }
}