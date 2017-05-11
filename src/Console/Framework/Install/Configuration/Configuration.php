<?php
namespace Frash\Console\Framework\Install\Configuration;

/**
 * Class Configuration
 * @package Frash\Console\Framework\Install\Configuration
 */
class Configuration{
	/**
	 * @param string $analyzer
	 * @param string $cache
	 * @param string $default_lang
	 * @param string $dispo_lang
	 * @return string                
	 */
	public static function file(string $analyzer, string $cache, string $default_lang, string $dispo_lang): string{
		$expl = explode('/', $dispo_lang);
		$array_lang = [];

		foreach($expl as $e){
			$array_lang[] = '\''.$e.'\'';
		}

		$trad_av = implode(', ', $array_lang);

		$content = '<?php'."\n";
		$content .= 'namespace Configuration;'."\n\n";
		$content .= 'class Config{'."\n";
		$content .= '	public static function define(){'."\n";
		$content .= '		return ['."\n";
		$content .= '			\'env\' => \'local\','."\n";
		$content .= '			\'stock_route\' => \'yes\','."\n";
        $content .= '			\'inspecter\' => ['."\n";
        $content .= '			    \'activ\' => \''.$analyzer.'\','."\n";
        $content .= '			    \'request\' => \'no\','."\n";
        $content .= '			],'."\n";
		$content .= '			\'racine\' => \'\','."\n";
		$content .= '			\'cache\' => ['."\n";
		$content .= '				\'memcached\' => [],'."\n";
		$content .= '				\'tpl\' => \''.$cache.'\''."\n";
		$content .= '			],'."\n";
		$content .= '			\'traduction\' => ['."\n";
		$content .= '				\'default\' => \''.$default_lang.'\','."\n";
		$content .= '				\'available\' => [ '.$trad_av.' ]'."\n";
		$content .= '			],'."\n";
		$content .= '			\'log\' => ['."\n";
		$content .= '			    \'access\' => ['."\n";
		$content .= '			        \'activ\' => \'yes\','."\n";
		$content .= '			        \'format\' => \'continu\''."\n";
		$content .= '			    ],'."\n";
        $content .= '			    \'ajax\' => ['."\n";
        $content .= '			        \'activ\' => \'yes\','."\n";
        $content .= '			        \'format\' => \'continu\''."\n";
        $content .= '			    ],'."\n";
        $content .= '			    \'error\' => ['."\n";
        $content .= '			        \'activ\' => \'yes\','."\n";
        $content .= '			        \'format\' => \'continu\''."\n";
        $content .= '			    ],'."\n";
        $content .= '			    \'request\' => ['."\n";
        $content .= '			        \'activ\' => \'yes\','."\n";
        $content .= '			        \'format\' => \'continu\''."\n";
        $content .= '			    ],'."\n";
        $content .= '			    \'simulation\' => ['."\n";
        $content .= '			        \'activ\' => \'yes\','."\n";
        $content .= '			        \'format\' => \'continu\''."\n";
        $content .= '			    ],'."\n";
		$content .= '			]'."\n";
		$content .= '		];'."\n";
		$content .= '	}'."\n";
		$content .= '}';

		return $content;
	}
}