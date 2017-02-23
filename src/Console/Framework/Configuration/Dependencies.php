<?php
namespace Frash\Console\Framework\Configuration;

/**
 * Class Dependencies
 * @package Frash\Console\Framework\Dependencies
 */
class Dependencies{
	/**
	 * @return string                
	 */
	public static function file(): string{
		$content = '<?php'."\n";
		$content .= 'namespace Configuration;'."\n\n";
		$content .= 'class Dependencies{'."\n";
		$content .= '	private static $dependencies = ['."\n";
		$content .= '		\'analyzer\' => \'Frash.Framework.Analyzer.Analyzer\','."\n";
		$content .= '		\'controller\' => \'Frash.Framework.Controller.Controller\','."\n";
		$content .= '		\'form\' => \'Frash.Framework.Forms.FormFactory\','."\n";
		$content .= '		\'getUrl\' => \'Frash.Framework.Controller.GetUrl\','."\n";
		$content .= '		\'mail\' => \'Frash.Framework.Mail.Mailer\','."\n";
		$content .= '		\'memcached\' => \'Frash.Framework.Cache.MemCache\','."\n";
		$content .= '		\'microtime\' => \'Frash.Framework.Utility.Microtime\','."\n";
		$content .= '		\'orm\' => \'Frash.ORM.OrmFactory\','."\n";
		$content .= '		\'redirect\' => \'Frash.Framework.Request.Redirect\','."\n";
		$content .= '		\'response\' => \'Frash.Framework.Request.Response\','."\n";
		$content .= '		\'route\' => \'Frash.Framework.Routing.Router\','."\n";
		$content .= '		\'service\' => \'Frash.Framework.Request.Service\','."\n";
		$content .= '		\'session\' => \'Frash.Framework.Request.Session\','."\n";
		$content .= '		\'trad\' => \'Frash.Framework.Controller.TraductionFactory\','."\n";
		$content .= '		\'twig\' => \'Frash.Framework.Controller.View\','."\n";
		$content .= '		\'tel\' => \'Frash.Framework.Controller.Templating\''."\n";
		$content .= '	];'."\n\n";
		$content .= '	public static function get(){'."\n";
		$content .= '		return self::$dependencies;'."\n";
		$content .= '	}'."\n";
		$content .= '}';

		return $content;
	}
}