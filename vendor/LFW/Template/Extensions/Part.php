<?php
namespace LFW\Template\Extensions;

/**
 * Class Part
 * @package LFW\Template\Extensions
 */
class Part{
    /**
     * @param string $part
     * @param string $name
     * @param array $incl_parent
     * @return string
     */
	public function parse(string $part, string $name, array $incl_parent): string{
		preg_match_all('/\[parent (\w+)\]/', $part, $name_parent, PREG_SET_ORDER);
		foreach($name_parent as $key => $tag){
			if(!empty($tag[1])){
				$part = str_replace('[parent '.$tag[1].']', $incl_parent[$tag[1]], $part);
			}
		}

		$code = '	public function part'.ucfirst($name).'(){'."\n";
		$code .= '		return \''.trim($part).'\';'."\n";
		$code .= '	}'."\n\n";

		return $code;
	}
}