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
		$content .= 'use Frash\Framework\FileSystem\LoadConfiguration;'."\n\n";
		$content .= 'class TestUnit extends LoadConfiguration{'."\n";
		$content .= '	private static $configuration = ['."\n";
		$content .= '		\'Frash\tests\Frash\Framework\CollectionTest\''."\n";
		$content .= '	];'."\n";
		$content .= '}';

		return $content;
	}
}