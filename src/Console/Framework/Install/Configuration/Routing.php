<?php
namespace Frash\Console\Framework\Configuration\Install;

/**
 * Class Routing
 * @package Frash\Console\Framework\Configuration\Install
 */
class Routing{
	/**
	 * @return string                
	 */
	public static function file(): string{
		$content = '<?php'."\n";
		$content .= 'namespace Configuration;'."\n";
		$content .= 'use Frash\Framework\Routing\Router;'."\n\n";
		$content .= 'class Routing extends Router{'."\n";
		$content .= '	public function __construct(){'."\n";
		$content .= '		'."\n";
		$content .= '	}'."\n";
		$content .= '}';

		return $content;
	}
}