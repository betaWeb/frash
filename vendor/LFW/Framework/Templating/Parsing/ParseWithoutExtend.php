<?php
	namespace LFW\Framework\Templating\Parsing;
	use LFW\Framework\Templating\Extensions\Routes;
	use LFW\Framework\Templating\Extensions\ShowVar;
	use LFW\Framework\Templating\Extensions\Import\ImportRessourcesBundle;

	class ParseWithoutExtend{
		public function parse($parsing, $tpl, $bundle, $nurl, $params, $lang, $name_parts){
			$class = 'Traductions\\Trad'.ucfirst($lang);
			$traduction = new $class;

			Routes::setJson();
			ShowVar::setParams($params);

			$level_part = 0;
			$escape = 0;
			$condition = 0;

			$for_simple = 0;
			$for_index = 0;
			$foreach = 0;
			$mapper = 0;

			preg_match_all('/\[(([a-z]*)?\s?([a-z\/@_\.]*))\]/', htmlentities($tpl), $res_split, PREG_SET_ORDER);
		    foreach($res_split as $key => $tag){
		    	switch(true){
		    		case (preg_match($parsing['escape'], $tag[0])):
		    			$escape++;
		    			break;
		    		case (preg_match($parsing['end_escape'], $tag[0])):
		    			$escape--;
		    			break;
		    		case $escape == 0:
		    			switch(true){
		    				case (preg_match($parsing['bundle'], $tag[0])):
		    					$p = (object) [ 'bundle' => $bundle, 'nurl' => $nurl[0] ];
		    					$tpl = str_replace($res_split[ $key ][0], ImportRessourcesBundle::parse($res_split[ $key ][3], $p), $tpl);
		    					break;
		    				case (preg_match($parsing['route'], $tag[0])):
		    					$tpl = str_replace($res_split[ $key ][0], Routes::parse($res_split[ $key ][3], $nurl, $params), $tpl);
		    					break;
		    				case (preg_match($parsing['traduction'], $tag[0])):
		    					$tpl = str_replace($res_split[ $key ][0], $traduction->show($res_split[ $key ][3]), $tpl);
		    					break;
		    				case (preg_match($parsing['parts'], $tag[0])):
		    					$level_part++;
			    				$name_parts[$res_split[ $key ][3]] = 'open';
		    					break;
		    				case $tag[0] == '[/part]':
		    					$level_part--;
			    				$name_parts[ count($name_parts) - 1 ]['statut'] = 'close';
		    					break;
		    				case (preg_match($parsing['parent'], $tag[0])):
		    					$name = $parts[ count($parts) - 1 ]['name'];
		    					break;
			    			case (preg_match($parsing['set_var'], $tag[0])):
			    				$params[$res_split[ $key ]] = $res_split[ $key + 2 ];
			    				$tpl = str_replace($res_split[ $key ][0], '', $tpl);
			    				break;
			    			case (preg_match($parsing['show_var'], $tag[0])):
			    				$tpl = str_replace($res_split[ $key ][0], ShowVar::parse($res_split[ $key ][3]), $tpl);
			    				break;
		    			}

		    			break;
		    	}
		    }

		    return $tpl;
		}

		private function importTraduction($trad, $class){
			$this->tpl = str_replace('[traduction '.$trad.']', $class->show($trad), $this->tpl);
		}
	}