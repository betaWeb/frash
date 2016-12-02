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
		private $trad = '';

        /**
         * @var array
         */
		private $parts_in_escape = [];

        /**
         * ParseTplParent constructor.
         * @param string $trad
         * @param string $bundle
         * @param string $display
         * @param DependTemplEngine $dic_t
         */
		public function __construct($trad, $bundle, $display, DependTemplEngine $dic_t){
			$this->bundle = $bundle;
			$this->display = $display;
			$this->dic_t = $dic_t;
			$this->trad = $trad;
		}

        /**
         * @return string
         */
		public function parse(){
			$level_escape = 0;

			preg_match_all('/\[(\/?)(([a-z]*)?\s?([a-z\/@_!=:,\.\s]*))\]/', $this->display, $res_split, PREG_SET_ORDER);
			foreach($res_split as $key => $tag){
				switch(true){
					case $level_escape == 0:
						switch(true){
							case preg_match($this->parsing['bundle'], $tag[0]):
								$this->display = str_replace($res_split[ $key ][0], $this->dic_t->load('Bundle')->parse($res_split[ $key ][4], $this->bundle), $this->display);
								break;
							case preg_match($this->parsing['route'], $tag[0]):
								$this->display = str_replace($res_split[ $key ][0], $this->dic_t->load('Route')->parse($res_split[ $key ][4]), $this->display);
								break;
							case preg_match($this->parsing['traduction'], $tag[0]):
								$this->display = str_replace($res_split[ $key ][0], $this->trad->show($res_split[ $key ][4]), $this->display);
								break;
							case preg_match($this->parsing['show_var'], $tag[0]):
								if($level_foreach == 0 && $level_for_simple == 0 && $level_for_index == 0 && $level_condition == 0 && $level_for_itvl == 0){
									$this->display = str_replace($res_split[ $key ][0], $this->dic_t->load('ShowVar')->parse($res_split[ $key ][4]), $this->display);
								}

								break;
						}

						break;
				}
			}

			return $this->display;
		}
	}