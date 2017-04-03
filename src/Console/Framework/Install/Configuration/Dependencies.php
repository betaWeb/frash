<?php
namespace Frash\Console\Framework\Configuration\Install;

/**
 * Class Dependencies
 * @package Frash\Console\Framework\Configuration\Install
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
		$content .= '			\'analyzer\' => \'Frash\\Framework\\Analyzer\\Analyzer\','."\n";
		$content .= '			\'browser\' => \'Frash\\Framework\\Browser\\Client\','."\n";
		$content .= '			\'controller\' => \'Frash\\Framework\\Controller\\Controller\','."\n";
		$content .= '			\'exception\' => \'Frash\\Framework\\Exception\\Exception\','."\n";
		$content .= '			\'form\' => \'Frash\\Framework\\Forms\\FormFactory\','."\n";
		$content .= '			\'getUrl\' => \'Frash\\Framework\\Controller\\GetUrl\','."\n";
		$content .= '			\'mail\' => \'Frash\\Framework\\Mail\\Mailer\','."\n";
		$content .= '			\'memcached\' => \'Frash\\Framework\\Cache\\MemCache\','."\n";
		$content .= '			\'microtime\' => \'Frash\\Framework\\Utility\\Microtime\','."\n";
		$content .= '			\'orm\' => \'Frash\\ORM\\OrmFactory\','."\n";
		$content .= '			\'redirect\' => \'Frash\\Framework\\Request\\Redirect\','."\n";
		$content .= '			\'response\' => \'Frash\\Framework\\Request\\Response\','."\n";
		$content .= '			\'service\' => \'Frash\\Framework\\Request\\Service\','."\n";
		$content .= '			\'session\' => \'Frash\\Framework\\Request\\Session\','."\n";
		$content .= '			\'trad\' => \'Frash\\Framework\\Controller\\TraductionFactory\','."\n";
		$content .= '			\'tpl\' => \'Frash\\Framework\\Controller\\Templating\''."\n";
		$content .= '		];'."\n";
		$content .= '	}'."\n";
		$content .= '}';

		return $content;
	}
}