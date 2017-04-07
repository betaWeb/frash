<?php
namespace Frash\Console\Framework\Install\Configuration;

/**
 * Class Console
 * @package Frash\Console\Framework\Install\Configuration
 */
class Console{
	/**
	 * @return string                
	 */
	public static function file(): string{
		$content = '<?php'."\n";
		$content .= 'namespace Configuration;'."\n\n";
		$content .= 'class Console{'."\n";
		$content .= '	public static function define(){'."\n";
		$content .= '		return ['."\n";
		$content .= '			\'default\' => ['."\n";
		$content .= '				\'Bundle:generate\' => \'Frash.Console.Bundle.GenerateBundle\','."\n";
		$content .= '				\'Check:routing\' => \'Frash.Console.Framework.Routing\','."\n";
		$content .= '				\'Clear:Cache\' => \'Frash.Console.Files.ClearCache\','."\n";
		$content .= '				\'Controller:generate\' => \'Frash.Console.Bundle.GenerateController\','."\n";
		$content .= '				\'Documentation:create\' => \'Frash.Console.Documentation.DocGen\','."\n";
		$content .= '				\'Framework:init\' => \'Frash.Console.Framework.Install.Init\','."\n";
		$content .= '				\'ORM:addentity\' => \'Frash.Console.ORM.Addentity\','."\n";
		$content .= '				\'ORM:createdb\' => \'Frash.Console.ORM.Createdb\','."\n";
		$content .= '				\'Test:Unit:run\' => \'Frash.UnitTest.CommandTest\''."\n";
		$content .= '			],'."\n";
		$content .= '			\'custom\' => []'."\n";
		$content .= '		];'."\n";
		$content .= '	}'."\n";
		$content .= '}';

		return $content;
	}
}