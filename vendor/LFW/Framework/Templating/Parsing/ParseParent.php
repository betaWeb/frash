<?php
	namespace LFW\Framework\Templating\Parsing;
	use LFW\Framework\Templating\Extensions\Routes;
	use LFW\Framework\Templating\Extensions\ShowVar;
	use LFW\Framework\Templating\Extensions\Import\ImportRessourcesBundle;

	class ParseParent{
		public static function parse($parent, $bundle, $lang, $params, $parsing, $nurl){
			if(strstr($parent, '::')){
				list($bundle, $file) = explode('::', $parent);
			}
			else{
				$file = $parent;
			}

			$tpl = file_get_contents('Bundles/'.$bundle.'/Views/'.$file);
			$clone_tpl = $tpl;
			$class = 'Traductions\\Trad'.ucfirst($lang);
			$traduction = new $class;

			Routes::setJson();
			ShowVar::setParams($params);

			$parts = [];
			$value_parts = [];
			$level_part = 0;

			$escape = 0;
			$condition = 0;

			$for_simple = 0;
			$for_index = 0;
			$foreach = 0;
			$mapper = 0;

			preg_match_all('/\[(\/?)(([a-z]*)?\s?([a-z\/@_\.]*))\]/', $tpl, $res_split, PREG_SET_ORDER);
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
		    					$tpl = str_replace($res_split[ $key ][0], ImportRessourcesBundle::parse($res_split[ $key ][4], $p), $tpl);
		    					break;
		    				case (preg_match($parsing['route'], $tag[0])):
		    					$tpl = str_replace($res_split[ $key ][0], Routes::parse($res_split[ $key ][4], $nurl, $params), $tpl);
		    					break;
		    				case (preg_match($parsing['traduction'], $tag[0])):
		    					$tpl = str_replace($res_split[ $key ][0], $traduction->show($res_split[ $key ][4]), $tpl);
		    					break;
		    				case (preg_match($parsing['parts'], $tag[0])):
		    					$parts[ $level_part ] = [ 'name' => $res_split[ $key ][4], 'statut' => 'open' ];
		    					$level_part++;
		    					break;
		    				case (preg_match($parsing['end_parts'], $tag[0])):
		    					$level_part--;
								$parts[ $level_part ]['statut'] = 'close';
		    					$name_part = $parts[ $level_part ]['name'];
		    					preg_match('/\[part '.$name_part.'\](.*)\[\/part '.$name_part.'\]/Us', $tpl, $match);
		    					$value_parts[ $name_part ] = $match[1];
		    					$tpl = str_replace($match[1], '', $tpl);
		    					break;
			    			case (preg_match($parsing['set_var'], $tag[0])):
			    				$params[$res_split[ $key ]] = $res_split[ $key + 3 ];
			    				$tpl = str_replace($res_split[ $key ][0], '', $tpl);
			    				break;
			    			case (preg_match($parsing['show_var'], $tag[0])):
			    				$tpl = str_replace($res_split[ $key ][0], ShowVar::parse($res_split[ $key ][4]), $tpl);
			    				break;
		    			}

		    			break;
		    	}
		    }

		    return [ 'tpl' => $tpl, 'value_parts' => $value_parts ];
		}
	}