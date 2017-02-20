<?php
namespace LFW\Template;
use LFW\Framework\FileSystem\{ File, InternalJson };
use LFW\Template\Parsing\ParseForSimple;

class LoaderForSimple{
	private $dic;
	private $dic_t;
	private $extensions;
	private $params;
	private $string;

	public function __construct(string $string, array $params, Dic $dic, array $extensions){
		$this->dic = $dic;
		$this->extensions = $extensions;
		$this->params = $params;
		$this->string = $string;

		$uri = $this->dic->get('uri');
        if(empty($uri)){
            $nurl = '';
        } elseif(strstr($uri, '/')){
            $nurl = explode('/', $uri);
        } else {
            $nurl = $uri;
        }

		$this->dic_t = new DependTemplEngine;
        $this->dic_t->setParams([
            'json' => InternalJson::importConfig(),
            'nurl' => $nurl,
            'prefix' => $this->dic->get('prefix'),
            'prefix_lang' => $this->dic->get('prefix_lang')
        ]);
	}

	public function parse(){
		$parser = new ParserForSimple($this->string, $this->params, $this->dic, $this->dic_t);
        $parser->parse();

        $path_class = 'Storage\Cache\Templating\String';
        $tpl_class = new $path_class($this->dic, $this->dic_t);
        echo $tpl_class->display();

        File::delete('Storage/Cache/Templating/String.php');
	}
}