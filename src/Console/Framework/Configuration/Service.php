<?php
namespace Frash\Console\Framework\Configuration;

/**
 * Class Service
 * @package Frash\Console\Framework\Service
 */
class Service{
	/**
	 * @return string                
	 */
	public static function file(): string{
		$content = '<?php'."\n";
		$content .= 'namespace Configuration;'."\n\n";
		$content .= 'class Service{'."\n";
		$content .= '	private static $service = ['."\n";
		$content .= '		'."\n";
		$content .= '	];'."\n\n";
		$content .= '	public static function get(){'."\n";
		$content .= '		return self::$service;'."\n";
		$content .= '	}'."\n";
		$content .= '}';

		return $content;
	}
}