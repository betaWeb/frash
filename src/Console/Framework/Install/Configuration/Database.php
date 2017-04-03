<?php
namespace Frash\Console\Framework\Configuration\Install;

/**
 * Class Database
 * @package Frash\Console\Framework\Configuration\Install
 */
class Database{
	/**
	 * @param string $bundle
	 * @return string                
	 */
	public static function file(string $bundle): string{
		$content = '<?php'."\n";
		$content .= 'namespace Configuration;'."\n\n";
		$content .= 'class Database{'."\n";
		$content .= '	public static function define(){'."\n";
		$content .= '		return ['."\n";
		$content .= '			\''.$bundle.'\' => ['."\n";
		$content .= '				\'host\' => \'\','."\n";
		$content .= '				\'username\' => \'\','."\n";
		$content .= '				\'password\' => \'\','."\n";
		$content .= '				\'dbname\' => \'\','."\n";
		$content .= '				\'system\' => \'\','."\n";
		$content .= '				\'port\' => \'\''."\n";
		$content .= '			]'."\n";
		$content .= '		];'."\n";
		$content .= '	}'."\n";
		$content .= '}';

		return $content;
	}
}