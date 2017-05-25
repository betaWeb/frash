<?php
namespace Frash\Console\Framework\Install\Configuration;

/**
 * Class Dependencies
 * @package Frash\Console\Framework\Install\Configuration
 */
class Dependencies{
	/**
	 * @return string                
	 */
	public static function file(): string{
		$content = '<?php'."\n";
		$content .= 'namespace Configuration;'."\n\n";
		$content .= 'class Dependencies{'."\n";
		$content .= '	public static function define(){'."\n";
		$content .= '		return ['."\n";
		$content .= '			\'browser\' => \'Frash\\Framework\\Browser\\Client\','."\n";
		$content .= '			\'controller\' => \'Frash\\Framework\\Controller\\Controller\','."\n";
		$content .= '			\'exception\' => \'Frash\\Framework\\Exception\\Exception\','."\n";
		$content .= '			\'form\' => \'Frash\\Framework\\Forms\\FormFactory\','."\n";
		$content .= '			\'inspecter\' => \'Frash\\Framework\\Inspecter\\Inspecter\','."\n";
		$content .= '			\'mail\' => \'Frash\\Framework\\Mail\\Mailer\','."\n";
		$content .= '			\'microtime\' => \'Frash\\Framework\\Utility\\Microtime\','."\n";
		$content .= '			\'orm\' => \'Frash\\ORM\\OrmFactory\','."\n";
		$content .= '			\'redirect\' => \'Frash\\Framework\\Request\\Redirect\','."\n";
		$content .= '			\'request\' => \'Frash\\Framework\\Request\\Request\','."\n";
		$content .= '			\'response\' => \'Frash\\Framework\\Request\\Response\','."\n";
		$content .= '			\'service\' => \'Frash\\Framework\\Request\\Service\','."\n";
		$content .= '			\'session\' => \'Frash\\Framework\\Request\\Session\\Session\','."\n";
		$content .= '			\'trad\' => \'Frash\\Framework\\Controller\\TraductionFactory\','."\n";
		$content .= '			\'tpl\' => \'Frash\\Framework\\Controller\\Templating\''."\n";
		$content .= '		];'."\n";
		$content .= '	}'."\n";
		$content .= '}';

		return $content;
	}
}