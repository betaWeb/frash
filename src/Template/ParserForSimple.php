<?php
namespace LFW\Template;

class ParseForSimple{
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
	private $env = '';

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
     * Parser constructor.
     * @param string $string
     * @param array $params
     * @param Dic $dic
     * @param DependTemplEngine $dic_t
     * @param string $name_class
     */
	public function __construct(string $string, array $params, Dic $dic, DependTemplEngine $dic_t){
		$this->dic = $dic;

		$this->env = $this->dic->get('env');
		$this->params = $params;
		$this->tpl = str_replace("'", "\'", $string);
		$this->name_class = 'String';
		$this->class_cache = CreateClassCache::create('String');

		$this->dic_t = $dic_t;
	}

	public function parse(){
    	preg_match('/\[extend (.*)\]/', $this->tpl, $extend);

		if(!empty($extend)){
			$parse = new ParseWithExtend(str_replace($extend[0], '', $this->tpl), $extend, $this->dic, $this->params, $this->dic_t);
			$this->class_cache .= $parse->parse();
		} else {
			$parse = new ParseWithoutExtend($this->tpl, $this->dic, $this->params, $this->dic_t);
			$this->class_cache .= $parse->parse();
		}

		$this->class_cache .= CreateClassCache::endClass();

		File::create('Storage/Cache/Templating/String.php', $this->class_cache);
	}
}