<?php
namespace Frash\Console\Framework\Install\Configuration;

/**
 * Class TestUnit
 * @package Frash\Console\Framework\Install\Configuration
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
		$content .= '			\'CollectionTest\' => \'FrashTest\Framework\CollectionTest\','."\n";
		$content .= '			\'GeneratorTest\' => \'FrashTest\Framework\Utility\GeneratorTest\''."\n";
		$content .= '		];'."\n";
		$content .= '	}'."\n";
		$content .= '}';

		return $content;
	}
}