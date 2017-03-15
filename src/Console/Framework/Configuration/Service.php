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
		$content .= 'use Frash\Framework\FileSystem\LoadConfiguration;'."\n\n";
		$content .= 'class Service extends LoadConfiguration{'."\n";
		$content .= '	private static $configuration = ['."\n";
		$content .= '		\'middleware\' => [],'."\n";
		$content .= '		\'templating\' => []'."\n";
		$content .= '	];'."\n";
		$content .= '}';

		return $content;
	}
}