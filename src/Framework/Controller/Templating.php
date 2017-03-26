<?php
namespace Frash\Framework\Controller;
use Frash\Framework\DIC\Dic;
use Frash\Template\Loader;

/**
 * Class Templating
 * @package Frash\Framework\Controller
 */
class Templating{
    /**
     * @var Dic
     */
    private $dic;

    /**
     * @var array
     */
    private $dump = [];

    /**
     * @var array
     */
    private $extensions = [];

    /**
     * @var boolean
     */
    private $no_cache = false;

    /**
     * Templating constructor.
     * @param Dic $dic
     */
	public function __construct(Dic $dic){
        $this->dic = $dic;
	}

    /**
     * @param string $name
     * @param mixed $dump
     */
    public function dump(string $name, $dump){
        $this->dump[ $name ] = $dump;
    }

    /**
     * @param string $regex
     * @param string $class
     */
    public function extension(string $regex, string $class){
        $this->extensions[ $regex ] = $class;
    }

    public function noCache(){
        $this->no_cache = true;
    }

    /**
     * @param array $params
     * @return array
     */
    private function internalParam(array $params = []): array{
        return array_merge([
            'dump' => $this->dump,
            'internal_prefix' => $this->dic->prefix,
            'internal_prefix_lang' => $this->dic->prefix_lang
        ], $params);
    }

    /**
     * @param string $file
     * @param array $param
     * @return object
     */
	public function view(string $file, array $param = []){
        return $this->load($file, $param)->view($this->no_cache);
	}

    /**
     * @param string $type
     * @param string $link
     * @param array $param
     * @return object
     */
    public function internal(string $type, string $link, array $param = []){
        return $this->load($link, $param)->internal($type, $this->no_cache);
    }

    /**
     * @param string $file
     * @param array $params
     * @return Loader
     */
    private function load(string $file, array $params): Loader{
        return new Loader($file, $this->internalParam($params), $this->dic, $this->extensions);
    }
}