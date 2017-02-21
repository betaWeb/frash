<?php
namespace Frash\Console\Framework\Configuration;

/**
 * Class Routing
 * @package Frash\Console\Framework\Routing
 */
class Routing{
	/**
	 * @return string                
	 */
	public static function file(): string{
		$content = '<?php'."\n";
		$content .= 'namespace Configuration;'."\n";
		$content .= 'use Frash\Framework\Routing\TreatmentPhp;'."\n\n";
		$content .= 'class Routing extends TreatmentPhp{'."\n";
		$content .= '	public function __construct(){'."\n";
		$content .= '		'."\n";
		$content .= '	}'."\n";
		$content .= '}';

		return $content;
	}
}