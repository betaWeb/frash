<?php
namespace Frash\Template\Extensions\Extensions;
use Frash\Template\Extensions\Extend\ExtensionParseSimple;

/**
 * Class Part
 * @package Frash\Template\Extensions\Extensions
 */
class Part extends ExtensionParseSimple{
	public function open(){
		$this->infos['level']['part']++;
        $this->infos['parts'][ $this->infos['level']['part'] ] = [ 'name' => $this->infos['params']['match'][3], 'value' => '' ];
	}

	public function close(){
		$name = $this->infos['parts'][ $this->infos['level']['part'] ]['name'];

        if($this->infos['level']['esc_tpl'] == 0){
            preg_match('/\{\{ part '.$name.' \}\}(.*)\{\{ end_part '.$name.' \}\}/Us', $this->infos['tpl'], $part_child);
            preg_match('/\{\{ part '.$name.' \}\}(.*)\{\{ end_part '.$name.' \}\}/Us', $this->infos['display'], $part_parent);

            $this->infos['display'] = str_replace($part_parent[0], '\'.$this->part'.ucfirst($name).'().\'', $this->infos['display']);

            preg_match_all('/\{\{ parent (\w+) \}\}/', $part_child[1], $name_parent, PREG_SET_ORDER);
			foreach($name_parent as $key => $tag){
				if(!empty($tag[1])){
					$part_child[1] = str_replace('{{ parent '.$tag[1].' }}', $this->infos['incl_parent'][ $tag[1] ], $part_child[1]);
				}
			}

			$code = '	public function part'.ucfirst($name).'(){'."\n";
			$code .= '		$content = \''.trim($part_child[1]).'\';'."\n\n";
			$code .= '		return $content;'."\n";
			$code .= '	}'."\n\n";

            $this->infos['class_cache'] .= $code;
        } elseif($this->infos['level']['escape_tpl'] > 0) {
            $this->infos['parts_in_escape'][] = $name;
        }

        $this->infos['level']['part']--;
	}

	public function parent(){
		$name = rtrim($this->infos['params']['match'][3]);

		preg_match('/\{\{ part '.$name.' \}\}(.*)\{\{ end_part '.$name.' \}\}/Us', $this->infos['display'], $match);

        $this->infos['tpl'] = str_replace('{{ parent '.$name.' }}', '\'.$this->parent'.ucfirst($name).'().\'', $this->infos['tpl']);
        $this->infos['class_cache'] .= $this->infos['params']['pp']->parse($name, $match[1]);
	}
}