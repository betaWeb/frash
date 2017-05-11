<?php
namespace Frash\Template\Parsing;
use Frash\Framework\DIC\Dic;
use Frash\Framework\FileSystem\File;
use Frash\Template\DependTemplEngine;
use Frash\Template\Cache\CreateClassCache;
use Frash\Template\Parsing\Parser;

/**
 * Class PreParser
 * @package Frash\Template\Parsing
 */
class PreParser{
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
     * PreParser constructor.
     * @param string $path
     * @param Dic $dic
     * @param DependTemplEngine $dic_t
     * @param string $name_class
     */
	public function __construct(string $path, Dic $dic, DependTemplEngine $dic_t, string $name_class){
		$this->dic = $dic;
		$this->dic_t = $dic_t;

		$this->tpl = str_replace("'", "\'", file_get_contents($path));
		$this->name_class = $name_class;
		$this->class_cache = CreateClassCache::create($this->name_class);
	}

	/**
	 * @param string $type
	 */
	public function parse(string $type = 'normal'){
		$is_extend = [ 0 => 'no' ];

		if(preg_match('/\{\{ extend (.*) \}\}/', $this->tpl, $extend)){
			$this->tpl = str_replace($extend[0], '', $this->tpl);
			$is_extend = $extend;
		}

		$parse = new Parser($this->tpl, $is_extend, $this->dic, $this->dic_t);
        $this->class_cache .= $parse->parse();

        if($this->dic->config['env'] == 'local' && $type == 'normal'){
			$this->class_cache = str_replace('</body>', '	\'.$this->bott_bar->parse().\''."\n".'	</body>', $this->class_cache);
		}

		$this->class_cache .= CreateClassCache::endClass();

		$name_file = ($type == 'normal') ? $this->name_class : 'Display'.$type;
		File::create('Storage/Cache/Templating/'.$name_file.'.php', $this->class_cache);
	}
}