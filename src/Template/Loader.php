<?php
namespace Frash\Template;
use Frash\Framework\DIC\Dic;
use Frash\Framework\Exception\Exception;
use Frash\Framework\FileSystem\{ Directory, File };
use Frash\Framework\Request\Server\Server;
use Frash\Framework\Utility\Generator;
use Frash\Template\DependTemplEngine;
use Frash\Template\Parsing\PreParser;

/**
 * Class Loader
 * @package Frash\Template
 */
class Loader{
    /**
     * @var string
     */
    private $bundle = '';

    /**
     * @var Dic
     */
    private $dic;

    /**
     * @var DependTemplEngine
     */
    private $dic_t;

    /**
     * @var string
     */
    private $file = '';

    /**
     * @var boolean
     */
    private $no_cache = false;

    /**
     * Loader constructor.
     * @param string $file
     * @param array $params
     * @param Dic $dic
     */
	public function __construct(string $file, array $params, Dic $dic, array $extensions){
        $this->dic = $dic;

		$this->bundle = $this->dic->bundle;
		$this->file = $file;
		$this->params = $params;

        $uri = $this->dic->uri;
        if(empty($uri)){
            $nurl = '';
        } elseif(strstr($uri, '/')){
            $nurl = explode('/', $uri);
        } else {
            $nurl = $uri;
        }

        $this->dic_t = new DependTemplEngine;
        $this->dic_t->sets([
            'config' => $dic->config,
            'nurl' => $nurl,
            'params' => $this->params,
            'prefix' => $this->dic->prefix,
            'prefix_lang' => $this->dic->prefix_lang
        ]);
	}

    /**
     * @param string $type
     * @param bool $no_cache
     */
    public function internal(string $type, bool $no_cache){
        Directory::notExistAndCreate('Storage/Cache/Templating');
        $name_file = 'Display'.$type;

        if(Server::refresh() && File::exist('Storage/Cache/Templating/'.$name_file.'.php')){
            File::delete('Storage/Cache/Templating/'.$name_file.'.php');
        }

        if(!File::exist('Storage/Cache/Templating/'.$name_file.'.php')){
            $parser = new PreParser($this->file, $this->dic, $this->dic_t, $name_file);
            $parser->parse($type);
        }

        $path_class = 'Storage\Cache\Templating\\'.$name_file;
        $tpl_class = new $path_class($this->dic, $this->dic_t, $this->dic->env);
        echo $tpl_class->display();

        $this->ifNoCache('Display'.$type);
    }

    /**
     * @param bool $no_cache
     * @return Exception
     */
    public function view(bool $no_cache){
        $this->no_cache = $no_cache;
        Directory::notExistAndCreate('Storage/Cache/Templating');

        if(!File::exist('Bundles/'.$this->bundle.'/Views/'.$this->file)){
            return $this->dic->load('exception')->publish('Template '.$this->file.' not found');
        }

        $name_file = 'Template'.Generator::get(10, true, true, true, false).md5(time().'Bundles/'.$this->bundle.'/Views/'.$this->file);

        $parser = new PreParser('Bundles/'.$this->bundle.'/Views/'.$this->file, $this->dic, $this->dic_t, $name_file);
        $parser->parse();

        $path_class = 'Storage\Cache\Templating\\'.$name_file;
        $tpl_class = new $path_class($this->dic, $this->dic_t, $this->dic->env);
        echo $tpl_class->display();

        $this->ifNoCache($name_file);
    }

    /**
     * @param string $file
     */
    private function ifNoCache(string $file){
        if($this->dic->cache_tpl != 'yes' || $this->no_cache === true){
            File::delete('Storage/Cache/Templating/'.$file.'.php');
        }
    }
}