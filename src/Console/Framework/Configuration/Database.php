<?php
namespace Frash\Console\Framework\Configuration;

/**
 * Class Database
 * @package Frash\Console\Framework\Database
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
		$content .= '	private static $database = ['."\n";
		$content .= '		\''.$bundle.'\' => ['."\n";
		$content .= '			\'host\' => \'\','."\n";
		$content .= '			\'username\' => \'\','."\n";
		$content .= '			\'password\' => \'\','."\n";
		$content .= '			\'dbname\' => \'\','."\n";
		$content .= '			\'system\' => \'\','."\n";
		$content .= '			\'port\' => \'\''."\n";
		$content .= '		]'."\n";
		$content .= '	];'."\n\n";
		$content .= '	public static function get(){'."\n";
		$content .= '		return self::$database;'."\n";
		$content .= '	}'."\n";
		$content .= '}';

		return $content;
	}
}