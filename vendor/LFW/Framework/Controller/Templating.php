<?php
namespace LFW\Framework\Controller;
use LFW\Framework\DIC\Dic;
use LFW\Template\{ Loader, LoaderForSimple };

/**
 * Class Templating
 * @package LFW\Framework\Controller
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
            'internal_prefix' => $this->dic->get('prefix'),
            'internal_prefix_lang' => $this->dic->get('prefix_lang')
        ], $params);
    }

    /**
     * @param string $string
     * @return bool
     */
    public function simple(string $string): bool{
        $loader = new LoaderForSimple($string, $this->internalParam(), $this->dic, $this->extensions);
        $loader->parse();

        return true;
    }

    /**
     * @param string $file
     * @param array $param
     * @return bool
     */
	public function view(string $file, array $param = []): bool{
        $loader = new Loader($file, $this->internalParam($param), $this->dic, $this->extensions);
        $loader->view($this->no_cache);

        return true;
	}

    /**
     * @param string $type
     * @param string $link
     * @param string $file
     * @param array $param
     * @return bool
     */
    public function internal(string $type, string $link, string $file, array $param = []): bool{
        $loader = new Loader($link, $this->getInternalParam($param), $this->dic, $this->extensions);
        $loader->internal($type, $file, $this->no_cache);

        return true;
    }
}