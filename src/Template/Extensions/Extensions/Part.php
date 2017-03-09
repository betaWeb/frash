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
        $this->infos['parts'][ $this->infos['level']['part'] ] = [ 'name' => $this->infos['params']['match'][4], 'value' => '' ];
	}

	public function close(){
		$name = $this->infos['parts'][ $this->infos['level']['part'] ]['name'];

        if($this->infos['level']['escape_tpl'] == 0){
            preg_match('/\[part '.$name.'\](.*)\[\/part '.$name.'\]/Us', $this->infos['tpl'], $part_child);
            preg_match('/\[part '.$name.'\](.*)\[\/part '.$name.'\]/Us', $this->infos['display'], $part_parent);

            $this->infos['display'] = str_replace($part_parent[0], '\'.$this->part'.ucfirst($name).'().\'', $this->infos['display']);

            preg_match_all('/\[parent (\w+)\]/', $part_child[1], $name_parent, PREG_SET_ORDER);
			foreach($name_parent as $key => $tag){
				if(!empty($tag[1])){
					$part_child[1] = str_replace('[parent '.$tag[1].']', $this->infos['incl_parent'][ $tag[1] ], $part_child[1]);
				}
			}

			$code = '	public function part'.ucfirst($name).'(){'."\n";
			$code .= '		return \''.trim($part_child[1]).'\';'."\n";
			$code .= '	}'."\n\n";

            $this->infos['class_cache'] .= $code;
        } elseif($this->infos['level']['escape_tpl'] > 0) {
            $this->infos['parts_in_escape'][] = $name;
        }

        $this->infos['level']['part']--;
	}

	public function parent(){
		preg_match('/\[part '.$this->infos['params']['match'][4].'\](.*)\[\/part '.$this->infos['params']['match'][4].'\]/Us', $this->infos['display'], $match);

        $this->infos['class_cache'] = str_replace($match[0], '\'.$this->parent'.ucfirst($this->infos['params']['match'][4]).'().\'', $this->infos['class_cache']);
        $this->infos['class_cache'] .= $this->infos['params']['pp']->parse($this->infos['params']['match'][4], $match[1]);
        $this->infos['incl_parent'][ $this->infos['params']['match'][4] ] = '\'.$this->parent'.ucfirst($this->infos['params']['match'][4]).'().\'';
	}
}