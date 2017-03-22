<?php
namespace Frash\Console\Framework\Configuration;

/**
 * Class TestUnit
 * @package Frash\Console\Framework\Configuration
 */
class TestUnit{
	/**
	 * @return string                
	 */
	public static function file(): string{
		$content = '<?php'."\n";
		$content .= 'namespace Configuration;'."\n\n";
		$content .= 'class TestUnit{'."\n";
		$content .= '	public static function define(){'."\n";
		$content .= '		return ['."\n";
		$content .= '			\'CollectionTest\' => \'FrashTest\Framework\CollectionTest\''."\n";
		$content .= '		];'."\n";
		$content .= '	}'."\n";
		$content .= '}';

		return $content;
	}
}