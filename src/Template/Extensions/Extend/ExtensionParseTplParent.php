<?php
namespace Frash\Template\Extensions\Extend;

/**
 * Class ExtensionParseTplParent
 * @package Frash\Template\Extend\Extensions
 */
class ExtensionParseTplParent{
    /**
     * @var array
     */
    protected $infos = [];

    /**
     * @param array $attributes
     * @param array $params
     */
    public function setInfos(array $attributes, array $params){
        $this->infos = $attributes;
        $this->infos['params'] = $params;
    }

    /**
     * @return array
     */
    public function getInfos(): array{
        return $this->infos;
    }
}