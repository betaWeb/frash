<?php
	namespace LFW\Framework\Templating\Parsing;
	use LFW\Framework\Templating\Extensions\Routes;
	use LFW\Framework\Templating\Extensions\ShowVar;
	use LFW\Framework\Templating\Extensions\Import\ImportRessourcesBundle;

	class ParseWithExtend{
		private $bundle = '';
		private $lang = '';
		private $params = [];
		private $parent = '';
		private $parsing = [];

		public function __construct($parent, $bundle, $lang, $params, $parsing, $nurl){
			$this->bundle = $bundle;
			$this->lang = $lang;
			$this->nurl = $nurl;
			$this->params = $params;
			$this->parent = ParseParent::parse($parent, $bundle, $lang, $params, $parsing, $nurl);
			$this->parsing = $parsing;
		}

		public function parse($tpl, $name_parts){
			$class = 'Traductions\\Trad'.ucfirst($this->lang);
			$traduction = new $class;

			Routes::setJson();
			ShowVar::setParams($this->params);

			$parts = [];
			$level_part = 0;

			$escape = 0;
			$condition = 0;

			$for_simple = 0;
			$for_index = 0;
			$foreach = 0;
			$mapper = 0;

			preg_match_all('/\[(\/?)(([a-z]*)?\s?([a-z\/@_\.]*))\]/', htmlentities($tpl), $res_split, PREG_SET_ORDER);
		    foreach($res_split as $key => $tag){
		    	switch(true){
		    		case (preg_match($this->parsing['escape'], $tag[0])):
		    			$escape++;
		    			break;
		    		case (preg_match($this->parsing['end_escape'], $tag[0])):
		    			$escape--;
		    			break;
		    		case $escape == 0:
		    			switch(true){
		    				case (preg_match($this->parsing['bundle'], $tag[0])):
		    					$p = (object) [ 'bundle' => $this->bundle, 'nurl' => $this->nurl[0] ];
		    					$tpl = str_replace($res_split[ $key ][0], ImportRessourcesBundle::parse($res_split[ $key ][4], $p), $tpl);
		    					break;
		    				case (preg_match($this->parsing['route'], $tag[0])):
		    					$tpl = str_replace($res_split[ $key ][0], Routes::parse($res_split[ $key ][4], $this->nurl, $this->params), $tpl);
		    					break;
		    				case (preg_match($this->parsing['traduction'], $tag[0])):
		    					$tpl = str_replace($res_split[ $key ][0], $traduction->show($res_split[ $key ][4]), $tpl);
		    					break;
		    				case (preg_match($this->parsing['parts'], $tag[0])):
		    					$level_part++;
		    					$parts[ $level_part ] = [ 'name' => $res_split[ $key ][4], 'statut' => 'open' ];
		    					break;
		    				case (preg_match($this->parsing['end_parts'], $tag[0])):
		    					if($level_part == 1){
		    						$name = $parts[ $level_part ]['name'];
		    						preg_match('/\[part '.$name.'\](.*)\[\/part '.$name.'\]/Us', $tpl, $match);
		    						$this->parent['tpl'] = str_replace('[part '.$name.'][/part '.$name.']', $match[1], $this->parent['tpl']);
		    					}
		    					
		    					$parts[ $level_part ]['statut'] = 'close';
		    					$level_part--;
		    					break;
		    				case (preg_match($this->parsing['parent'], $tag[0])):
		    					$name = $parts[ $level_part ]['name'];
		    					$tpl = str_replace('[parent this]', $this->parent['value_parts'][ $name ], $tpl);
		    					break;
			    			case (preg_match($this->parsing['set_var'], $tag[0])):
			    				$this->params[$res_split[ $key ]] = $res_split[ $key + 3 ];
			    				$tpl = str_replace($res_split[ $key ][0], '', $tpl);
			    				break;
			    			case (preg_match($this->parsing['show_var'], $tag[0])):
			    				$tpl = str_replace($res_split[ $key ][0], ShowVar::parse($res_split[ $key ][4]), $tpl);
			    				break;
		    			}

		    			break;
		    	}
		    }

		    return $this->parent['tpl'];
		}

		private function importTraduction($trad, $class){
			$this->tpl = str_replace('[traduction '.$trad.']', $class->show($trad), $this->tpl);
		}
	}