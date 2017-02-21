<?php
namespace Frash\Console\Framework\Configuration;

/**
 * Class Console
 * @package Frash\Console\Framework\Console
 */
class Console{
	/**
	 * @return string                
	 */
	public static function file(): string{
		$content = '<?php'."\n";
		$content .= 'namespace Configuration;'."\n\n";
		$content .= 'class Console{'."\n";
		$content .= '	private static $console = ['."\n";
		$content .= '		\'default\' => ['."\n";
		$content .= '			\'Bundle:generate\' => \'Frash.Console.Bundle.GenerateBundle\','."\n";
		$content .= '			\'Clear:Cache\' => \'Frash.Console.Files.ClearCache\','."\n";
		$content .= '			\'Controller:generate\' => \'Frash.Console.Bundle.GenerateController\','."\n";
		$content .= '			\'Documentation:create\' => \'Frash.Console.Documentation.DocGen\','."\n";
		$content .= '			\'Framework:init\' => \'Frash.Console.Framework.Init\','."\n";
		$content .= '			\'ORM:addentity\' => \'Frash.Console.ORM.Addentity\','."\n";
		$content .= '			\'ORM:createdb\' => \'Frash.Console.ORM.Createdb\','."\n";
		$content .= '			\'Test:Unit:run\' => \'Frash.UnitTest.CommandTest\''."\n";
		$content .= '		],'."\n";
		$content .= '		\'custom\' => []'."\n";
		$content .= '	];'."\n\n";
		$content .= '	public static function get(){'."\n";
		$content .= '		return self::$console;'."\n";
		$content .= '	}'."\n";
		$content .= '}';

		return $content;
	}
}