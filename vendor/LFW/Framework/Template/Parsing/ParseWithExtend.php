<?php
	namespace LFW\Framework\Template\Parsing;
    use LFW\Framework\DIC\Dic;
	use LFW\Framework\Template\DependTemplEngine;
	use LFW\Framework\Template\Parsing\ParseArray;
	use LFW\Framework\Template\Parsing\ParseParent;
	use LFW\Framework\Template\Parsing\ParseTplParent;

    /**
     * Class ParseWithExtend
     * @package LFW\Framework\Template\Parsing
     */
	class ParseWithExtend extends ParseArray{
        /**
         * @var string
         */
		private $bundle = '';

        /**
         * @var string
         */
		private $class_cache = '';

        /**
         * @var array
         */
		private $params = [];

        /**
         * @var array|string
         */
		private $parent = [];

        /**
         * @var string
         */
		private $tpl = '';

        /**
         * @var array
         */
		private $incl_parent = [];

        /**
         * @var object
         */
		private $trad;

        /**
         * @var DependTemplEngine
         */
		private $dic_t;

        /**
         * ParseWithExtend constructor.
         * @param string $tpl
         * @param string $extend
         * @param Dic $dic
         * @param array $params
         * @param DependTemplEngine $dic_t
         */
		public function __construct($tpl, $extend, Dic $dic, $params, DependTemplEngine $dic_t){
			$gets = $dic->load('get');
			$this->bundle = $gets->get('bundle');
			$this->dic_t = $dic_t;

			$class_trad = 'Traductions\\Trad'.ucfirst($gets->get('lang'));
			$this->trad = new $class_trad;

			$this->params = $params;
			$this->parent = file_get_contents($this->determinatePathExtend($extend[1]));
			$this->tpl = $tpl;

			$this->class_cache = '		public function display(){'."\n";
			$this->class_cache .= '			return \''.$this->parent.'\';'."\n";
			$this->class_cache .= '		}'."\n\n";
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
			$level_part = 0;

			$condition = [];
			$foreach = [];
			$list_methods = [];
			$parts = [];

			$pp = new ParseParent($this->trad, $this->bundle, $this->tpl, $this->dic_t);

			preg_match_all('/\[(\/?)(([a-zA-Z]*)?\s?([a-zA-Z0-9\/@_!=:",\.\s]*))\]/', $this->tpl, $match_all, PREG_SET_ORDER);
			foreach($match_all as $key => $tag){
				switch(true){
					case (preg_match($this->parsing['escape'], $tag[0])):
						$level_escape++;
						break;
					case (preg_match($this->parsing['end_escape'], $tag[0])):
						preg_match('/\[escape\](.*)\[\/escape\]/Us', $this->tpl, $match);
						$this->class_cache .= $this->dic_t->load('Escape')->parse($match);
						$this->tpl = str_replace($match[0], '\'.$this->escape'.md5($match[1]).'().\'', $this->tpl);
						$level_escape--;
						break;
					case $level_escape == 0:
						switch(true){
							case preg_match($this->parsing['bundle'], $tag[0]):
								if($level_foreach == 0 && $level_for_simple == 0 && $level_for_index == 0 && $level_for_itvl == 0){
									$this->tpl = str_replace($match_all[ $key ][0], $this->dic_t->load('Bundle')->parse($match_all[ $key ][4], $this->bundle), $this->tpl);
								}

								break;
							case preg_match($this->parsing['call'], $tag[0]):
								break;
							case preg_match($this->parsing['else'], $tag[0]):
								$condition[ $level_condition ][] = [ 'type' => 'else', 'condition' => 'else' ];
								break;
							case preg_match($this->parsing['elseif'], $tag[0]):
								$condition[ $level_condition ][] = [ 'type' => 'elseif', 'condition' => $match_all[ $key ][2] ];
								break;
							case preg_match($this->parsing['end_condition'], $tag[0]):
								$condition[ $level_condition ][] = [ 'type' => 'end', 'condition' => '/condition' ];

								$cp = $this->dic_t->load('Condition')->parse($condition[ $level_condition ], $this->tpl);
								$this->class_cache .= $cp['code'];
								$this->tpl = str_replace($cp['replace'], '\'.$this->'.$cp['name'].'().\'', $this->tpl);

								unset($condition[ $level_condition ]);
								$level_condition--;
								break;
							case preg_match($this->parsing['end_for_index'], $tag[0]):
								break;
							case preg_match($this->parsing['end_for_itvl'], $tag[0]):
								break;
							case preg_match($this->parsing['end_for_simple'], $tag[0]):
								break;
							case preg_match($this->parsing['end_foreach'], $tag[0]):
								preg_match('/\[foreach '.$foreach[ $level_foreach ]['param'].'\](.*)\[\/foreach\]/Us', $this->tpl, $match);
								$this->class_cache .= $this->dic_t->load('Foreach')->parse($foreach[ $level_foreach ]['param'], $match[1]);
								$this->tpl = str_replace($match[0], '\'.$this->foreach'.md5($foreach[ $level_foreach ]['param']).'().\'', $this->tpl);
								$level_foreach--;
								break;
							case preg_match($this->parsing['end_func'], $tag[0]):
								break;
							case preg_match($this->parsing['end_parts'], $tag[0]):
								$name = $parts[ $level_part ]['name'];
								preg_match('/\[part '.$name.'\](.*)\[\/part '.$name.'\]/Us', $this->tpl, $part_child);
								preg_match('/\[part '.$name.'\](.*)\[\/part '.$name.'\]/Us', $this->class_cache, $part_parent);

								$this->class_cache = str_replace($part_parent[0], '\'.$this->part'.ucfirst($name).'().\'', $this->class_cache);
								$this->class_cache .= $this->dic_t->load('Part')->parse($part_child[1], $name, $this->incl_parent);
								$list_methods[] = '\'.$this->part'.ucfirst($name).'().\'';

								$level_part--;
								break;
							case preg_match($this->parsing['for_index'], $tag[0]):
								break;
							case preg_match($this->parsing['for_itvl'], $tag[0]):
								break;
							case preg_match($this->parsing['for_simple'], $tag[0]):
								break;
							case preg_match($this->parsing['foreach'], $tag[0]):
								$level_foreach++;
								$foreach[ $level_foreach ] = [ 'foreach' => $match_all[ $key ][0], 'param' => $match_all[ $key ][4] ];
								break;
							case preg_match($this->parsing['if'], $tag[0]):
								$level_condition++;
								$condition[ $level_condition ][] = [ 'type' => 'if', 'condition' => $match_all[ $key ][2] ];
								break;
							case preg_match($this->parsing['include'], $tag[0]):
								break;
							case preg_match($this->parsing['parent'], $tag[0]):
								preg_match('/\[part '.$match_all[ $key ][4].'\](.*)\[\/part '.$match_all[ $key ][4].'\]/Us', $this->class_cache, $match);
								$this->class_cache = str_replace($match[0], '\'.$this->parent'.ucfirst($match_all[ $key ][4]).'().\'', $this->class_cache);
								$this->class_cache .= $pp->parse($match_all[ $key ][4], $match[1]);

								$this->incl_parent[$match_all[ $key ][4]] = '\'.$this->parent'.ucfirst($match_all[ $key ][4]).'().\'';
								$list_methods[] = '\'.$this->parent'.ucfirst($match_all[ $key ][4]).'().\'';

								break;
							case preg_match($this->parsing['parts'], $tag[0]):
								$level_part++;
								$parts[ $level_part ] = [ 'name' => $match_all[ $key ][4], 'value' => '' ];
								break;
							case preg_match($this->parsing['route'], $tag[0]):
								if($level_foreach == 0 && $level_for_simple == 0 && $level_for_index == 0 && $level_for_itvl == 0){
									$this->tpl = str_replace($match_all[ $key ][0], $this->dic_t->load('Route')->parse($match_all[ $key ][4]), $this->tpl);
								}

								break;
							case preg_match($this->parsing['set_func'], $tag[0]):
								break;
							case preg_match($this->parsing['set_var'], $tag[0]):
								if($level_foreach == 0 && $level_for_simple == 0 && $level_for_index == 0 && $level_for_itvl == 0){
									preg_match('/\[\@(\w+)\](.*)\[\/var]/', $this->tpl, $set_var);
									$this->params[$set_var[1]] = $set_var[2];
								}

								break;
							case preg_match($this->parsing['show_var'], $tag[0]):
								if($level_foreach == 0 && $level_for_simple == 0 && $level_for_index == 0 && $level_for_itvl == 0){
									$this->tpl = str_replace($match_all[ $key ][0], $this->dic_t->load('ShowVar')->parse($match_all[ $key ][4]), $this->tpl);
								}

								break;
							case preg_match($this->parsing['traduction'], $tag[0]):
								$this->tpl = str_replace($match_all[ $key ][0], str_replace('\'', "\'", $this->trad->show($match_all[ $key ][4])), $this->tpl);
								break;
						}

						break;
				}
			}

			$ptp = new ParseTplParent($this->trad, $this->bundle, $this->tpl, $this->class_cache, $this->dic_t);
			$this->class_cache = $ptp->parse();

			$this->removeUnuseParts();
			return $this->class_cache;
		}

        /**
         * @param string $extend
         * @return string
         */
		private function determinatePathExtend($extend){
			if(strstr($extend, '::')){
				list($bundle, $file) = explode('::', $extend);
			}
			else{
				$file = $extend;
				$bundle = $this->bundle;
			}

			return 'Bundles/'.$bundle.'/Views/'.$file;
		}

		private function removeUnuseParts(){
			$this->class_cache = preg_replace('/\[part (\w+)\](.*)\[\/part (\w+)\]/Us', '', $this->class_cache);
		}
	}