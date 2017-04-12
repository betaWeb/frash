<?php
namespace Frash\Template\Extensions;
use Frash\Template\DependTemplEngine;

/**
 * Class CallExtension
 * @package Frash\Template\Extensions
 */
class CallExtension{
	/**
	 * @var DependTemplEngine
	 */
	private $dic_t;

    /**
     * CallExtension constructor.
     * @param DependTemplEngine $dic_t
     * @param array $params
     */
    public function __construct(DependTemplEngine $dic_t, array $params){
        $this->dic_t = $dic_t;
    }

	public function parse(string $extension, string $method, array $attributes, array $params = []){
		$extension = $this->dic_t->extension($extension);
        $extension->setInfos($attributes, $params);
        $extension->$method();

        return $extension;
	}

    public function parseForeach(string $extension, string $method, array $attributes, array $params = []){
        $extension = $this->dic_t->extension($extension);
        $extension->setInfos($attributes, $params);
        $extension->$method();

        return $extension;
    }

    public function parseParent(string $extension, string $method, array $attributes, array $params = []){
        $extension = $this->dic_t->extension($extension);
        $extension->setInfos($attributes, $params);
        $extension->$method();

        return $extension;
    }

    public function parseTplParent(string $extension, string $method, array $attributes, array $params = []){
        $extension = $this->dic_t->extension($extension);
        $extension->setInfos($attributes, $params);
        $extension->$method();

        return $extension;
    }
}