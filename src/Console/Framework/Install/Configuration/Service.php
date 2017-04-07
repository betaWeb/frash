<?php
namespace Frash\Console\Framework\Install\Configuration;

/**
 * Class Service
 * @package Frash\Console\Framework\Install\Configuration
 */
class Service{
	/**
	 * @return string                
	 */
	public static function file(): string{
		$content = '<?php'."\n";
		$content .= 'namespace Configuration;'."\n\n";
		$content .= 'class Service{'."\n";
		$content .= '	public static function define(){'."\n";
		$content .= '		return ['."\n";
		$content .= '			\'middleware\' => [],'."\n";
		$content .= '			\'templating\' => []'."\n";
		$content .= '		];'."\n";
		$content .= '	}'."\n";
		$content .= '}';

		return $content;
	}
}