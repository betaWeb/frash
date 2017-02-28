<?php
namespace Frash\Console\Framework\Configuration;

/**
 * Class Configuration
 * @package Frash\Console\Framework\Configuration
 */
class Configuration{
	/**
	 * @param string $analyzer
	 * @param string $cache
	 * @param string $default_lang
	 * @param string $dispo_lang
	 * @param string $access_log
	 * @param string $ajax_log
	 * @param string $error_log
	 * @param string $request_log
	 * @return string                
	 */
	public static function file(string $analyzer, string $cache, string $default_lang, string $dispo_lang, string $access_log, string $ajax_log, string $error_log, string $request_log): string{
		$expl = explode('/', $dispo_lang);
		$array_lang = [];

		foreach($expl as $e){
			$array_lang[] = '\''.$e.'\'';
		}

		$trad_av = implode(', ', $array_lang);

		$content = '<?php'."\n";
		$content .= 'namespace Configuration;'."\n\n";
		$content .= 'class Config{'."\n";
		$content .= '	private static $config = ['."\n";
		$content .= '		\'env\' => \'local\','."\n";
		$content .= '		\'stock_route\' => \'yes\','."\n";
		$content .= '		\'analyzer\' => \''.$analyzer.'\','."\n";
		$content .= '		\'racine\' => ['."\n";
		$content .= '			\'route\' => \'\','."\n";
		$content .= '			\'path\' => \'\','."\n";
		$content .= '		],'."\n";
		$content .= '		\'cache\' => ['."\n";
		$content .= '			\'memcached\' => [],'."\n";
		$content .= '			\'tpl\' => \''.$cache.'\''."\n";
		$content .= '		],'."\n";
		$content .= '		\'traduction\' => ['."\n";
		$content .= '			\'default\' => \''.$default_lang.'\','."\n";
		$content .= '			\'available\' => [ '.$trad_av.' ]'."\n";
		$content .= '		],'."\n";
		$content .= '		\'log\' => ['."\n";
		$content .= '			\'access\' => \''.$access_log.'\','."\n";
		$content .= '			\'ajax\' => \''.$ajax_log.'\','."\n";
		$content .= '			\'error\' => \''.$error_log.'\','."\n";
		$content .= '			\'request\' => \''.$request_log.'\','."\n";
		$content .= '		]'."\n";
		$content .= '	];'."\n\n";
		$content .= '	public static function get(){'."\n";
		$content .= '		return self::$config;'."\n";
		$content .= '	}'."\n";
		$content .= '}';

		return $content;
	}
}