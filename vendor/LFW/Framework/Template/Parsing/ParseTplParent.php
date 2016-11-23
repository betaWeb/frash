<?php
	namespace LFW\Framework\Template\Parsing;
	use LFW\Framework\Template\DependTemplEngine;
	use LFW\Framework\Template\Parsing\ParseArray;

    /**
     * Class ParseTplParent
     * @package LFW\Framework\Template\Parsing
     */
	class ParseTplParent extends ParseArray{
        /**
         * @var string
         */
		private $bundle = '';

        /**
         * @var string
         */
		private $class_cache = '';

        /**
         * @var DependTemplEngine
         */
		private $dic_t;

        /**
         * @var string
         */
		private $tpl = '';

        /**
         * @var string
         */
		private $trad = '';

        /**
         * ParseTplParent constructor.
         * @param string $trad
         * @param string $bundle
         * @param string $tpl
         * @param string $class_cache
         * @param DependTemplEngine $dic_t
         */
		public function __construct($trad, $bundle, $tpl, $class_cache, DependTemplEngine $dic_t){
			$this->bundle = $bundle;
			$this->class_cache = $class_cache;
			$this->dic_t = $dic_t;
			$this->tpl = $tpl;
			$this->trad = $trad;
		}

        /**
         * @return string
         */
		public function parse(){
			$level_condition = 0;
			$level_escape = 0;
			$level_for_index = 0;
			$level_for_itvl = 0;
			$level_for_simple = 0;
			$level_foreach = 0;

			preg_match_all('/\[(\/?)(([a-z]*)?\s?([a-z\/@_!=:,\.\s]*))\]/', $this->class_cache, $res_split, PREG_SET_ORDER);
			foreach($res_split as $key => $tag){
				switch(true){
					case $level_escape == 0:
						switch(true){
							case preg_match($this->parsing['bundle'], $tag[0]):
								$this->class_cache = str_replace($res_split[ $key ][0], $this->dic_t->load('Bundle')->parse($res_split[ $key ][4], $this->bundle), $this->class_cache);
								break;
							case preg_match($this->parsing['route'], $tag[0]):
								$this->class_cache = str_replace($res_split[ $key ][0], $this->dic_t->load('Route')->parse($res_split[ $key ][4]), $this->class_cache);
								break;
							case preg_match($this->parsing['traduction'], $tag[0]):
								$this->class_cache = str_replace($res_split[ $key ][0], $this->trad->show($res_split[ $key ][4]), $this->class_cache);
								break;
							case preg_match($this->parsing['show_var'], $tag[0]):
								if($level_foreach == 0 && $level_for_simple == 0 && $level_for_index == 0 && $level_condition == 0 && $level_for_itvl == 0){
									$this->tpl = str_replace($res_split[ $key ][0], $this->dic_t->load('ShowVar')->parse($res_split[ $key ][4]), $this->tpl);
								}

								break;
						}

						break;
				}
			}

			return $this->class_cache;
		}
	}