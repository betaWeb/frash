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
		$content .= '				\'Check:routing\' => \'Frash.Console.Framework.Routing\','."\n";
		$content .= '				\'Clear:Cache\' => \'Frash.Console.Files.ClearCache\','."\n";
		$content .= '				\'Framework:init\' => \'Frash.Console.Framework.Install.Init\','."\n";
		$content .= '				\'Generate:bundle\' => \'Frash.Console.Bundle.GenerateBundle\','."\n";
		$content .= '				\'Generate:controller\' => \'Frash.Console.Bundle.GenerateController\','."\n";
		$content .= '				\'Generate:documentation\' => \'Frash.Console.Documentation.DocGen\','."\n";
		$content .= '				\'ORM:addentity\' => \'Frash.Console.ORM.Addentity\','."\n";
		$content .= '				\'ORM:import\' => \'Frash.Console.ORM.Import\','."\n";
		$content .= '				\'ORM:migration\' => \'Frash.Console.ORM.Migration\','."\n";
		$content .= '				\'Test:Unit:run\' => \'Frash.UnitTest.CommandTest\''."\n";
		$content .= '			],'."\n";
		$content .= '			\'custom\' => []'."\n";
		$content .= '		];'."\n";
		$content .= '	}'."\n";
		$content .= '}';

		return $content;
	}
}