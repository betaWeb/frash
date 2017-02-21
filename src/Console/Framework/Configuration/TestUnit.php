<?php
namespace Frash\Console\Framework\Configuration;

/**
 * Class TestUnit
 * @package Frash\Console\Framework\TestUnit
 */
class TestUnit{
	/**
	 * @return string                
	 */
	public static function file(): string{
		$content = '<?php'."\n";
		$content .= 'namespace Configuration;'."\n\n";
		$content .= 'class TestUnit{'."\n";
		$content .= '	private static $test_unit = ['."\n";
		$content .= '		'."\n";
		$content .= '	];'."\n\n";
		$content .= '	public static function get(){'."\n";
		$content .= '		return self::$test_unit;'."\n";
		$content .= '	}'."\n";
		$content .= '}';

		return $content;
	}
}