<?php
namespace Frash\Template;
use Frash\Framework\DIC\Dic;
use Frash\Framework\FileSystem\File;
use Frash\Template\DependTemplEngine;
use Frash\Template\Cache\CreateClassCache;
use Frash\Template\Parsing\{ ParseWithExtend, ParseWithoutExtend };

/**
 * Class Parser
 * @package Frash\Template
 */
class Parser{
    /**
     * @var Dic
     */
	private $dic;

    /**
     * @var DependTemplEngine
     */
	private $dic_t;

    /**
     * @var array
     */
	private $params = [];

    /**
     * @var string
     */
	private $class_cache = '';

    /**
     * @var string
     */
	private $name_class = '';

    /**
     * @var mixed|string
     */
	private $tpl = '';

    /**
     * @var string
     */
    private $type = '';

    /**
     * Parser constructor.
     * @param string $path
     * @param array $params
     * @param Dic $dic
     * @param DependTemplEngine $dic_t
     * @param string $name_class
     */
	public function __construct(string $path, array $params, Dic $dic, DependTemplEngine $dic_t, string $name_class){
		$this->dic = $dic;

		$this->params = $params;
		$this->tpl = str_replace("'", "\'", file_get_contents($path));
		$this->name_class = $name_class;
		$this->class_cache = CreateClassCache::create($this->name_class);

		$this->dic_t = $dic_t;
	}

	public function parse(string $type = 'normal'){
	    $this->type = $type;

    	preg_match('/\[extend (.*)\]/', $this->tpl, $extend);

		if(!empty($extend)){
			$parse = new ParseWithExtend(str_replace($extend[0], '', $this->tpl), $extend, $this->dic, $this->params, $this->dic_t);
		} else {
			$parse = new ParseWithoutExtend($this->tpl, $this->dic, $this->params, $this->dic_t);
		}

        $this->class_cache .= $parse->parse();
		$this->importBottomBar();
		$this->class_cache .= CreateClassCache::endClass();

		if($type == 'normal'){
			File::create('Storage/Cache/Templating/'.$this->name_class.'.php', $this->class_cache);
		} elseif($type == 'Analyzer') {
			File::create('Storage/Cache/Templating/DisplayAnalyzer.php', $this->class_cache);
		}
	}

	private function importBottomBar(){
		if($this->dic->get('env') == 'local' && $this->type == 'normal'){
			$this->class_cache = str_replace('</body>', '	\'.$this->bott_bar->parse().\''."\n".'	</body>', $this->class_cache);
		}
	}
}