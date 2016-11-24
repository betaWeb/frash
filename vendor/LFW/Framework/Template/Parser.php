<?php
	namespace LFW\Framework\Template;
    use LFW\Framework\DIC\Dic;
	use LFW\Framework\Template\Cache\CreateClassCache;
	use LFW\Framework\Template\Parsing\ParseWithExtend;

    /**
     * Class Parser
     * @package LFW\Framework\Template
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
         * @param string $path
         * @param array $params
         * @param Dic $dic
         */
		public function __construct($path, $params, Dic $dic){
			$this->dic = $dic;
			$this->env = $this->dic->open('get')->get('env');
			$this->params = $params;
			$this->tpl = str_replace("'", "\'", file_get_contents($path));
			$this->name_class = 'TemplateOf'.md5($path);
			$this->class_cache = CreateClassCache::create($this->name_class);

			$this->dic_t = new DependTemplEngine;
			$this->dic_t->setParams('json', json_decode(file_get_contents('Configuration/config.json'), true));
			$this->dic_t->setParams('nurl', explode('/', $dic->open('get')->get('uri')));
			$this->dic_t->setParams('params', $this->params);
		}

		public function parse(){
			preg_match('/\[extend\](.*)\[\/extend\]/s', $this->tpl, $extend);

			if(!empty($extend)){
				$parse = new ParseWithExtend(str_replace($extend[0], '', $this->tpl), $extend, $this->dic, $this->params, $this->dic_t);
				$this->class_cache .= $parse->parse();
			}
			else{
				// ParseWithoutExtend
			}

			$this->importBottomBar();
			$this->class_cache .= CreateClassCache::endClass();
			file_put_contents('vendor/LFW/Cache/Templating/'.$this->name_class.'.php', $this->class_cache);

			$path_class = 'LFW\Cache\Templating\\'.$this->name_class;
			$tpl_class = new $path_class($this->dic, $this->dic_t, $this->params, $this->env);
			echo $tpl_class->display();
		}

		private function importBottomBar(){
			if($this->env == 'local'){
				//$this->class_cache = str_replace('</body>', '	\'.$this->bott_bar->parse().\''."\n".'	</body>', $this->class_cache);
			}
		}
	}