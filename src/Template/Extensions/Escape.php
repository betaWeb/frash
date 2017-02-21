<?php
namespace Frash\Template\Extensions;

/**
 * Class Escape
 * @package Frash\Template\Extensions
 */
class Escape{
    /**
     * @param array $escaping
     * @return string
     */
	public function parse(array $escaping): string{
		$code = '	private function escape'.md5($escaping[1]).'(){'."\n";
		$code .= '		return \''.trim(htmlentities($escaping[1])).'\';'."\n";
		$code .= '	}'."\n\n";

		return $code;
	}
}