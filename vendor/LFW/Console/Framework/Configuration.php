<?php
namespace LFW\Console\Framework;
use LFW\Framework\FileSystem\{ Directory, File, Json };

/**
 * Class Configuration
 * @package LFW\Console\Framework
 */
class Configuration
{
    public static function preinstall()
    {
        if(!file_exists('Configuration/')){
            echo 'Dossier Configuration créé !'.PHP_EOL;
            Directory::create('Configuration/', 0770);
        }
    }

    public static function htaccess()
    {
        File::create('Configuration/.htaccess', 'Deny from all');
    }

    /**
     * @param string $format_routing
     * @param string $analyzer
     * @param string $cache
     * @param string $default_lang
     * @param string $dispo_lang
     * @param string $access_log
     * @param string $error_log
     * @param string $request_log
     */
	public static function config($format_routing, $analyzer, $cache, $default_lang, $dispo_lang, $access_log, $error_log, $request_log)
    {
		$array = [
			'env' => 'local',
			'routing' => $format_routing,
            'stock_route' => 'yes',
			'analyzer' => $analyzer,
			'racine' => [ 'route' => '', 'path' => '' ],
			'cache' => [ 'memcached' => [], 'tpl' => $cache ],
			'traduction' => [
				'default' => $default_lang,
				'available' => explode('/', $dispo_lang)
			],
			'log' => [ 'access' => $access_log, 'error' => $error_log, 'request' => $request_log ]
		];

		File::create('Configuration/config.json', Json::encode($array, 'JSON_PRETTY_PRINT'));
	}

    /**
     * @param string $bundle
     */
	public static function database($bundle)
    {
		$array = [
			$bundle => [ 'host' => 'localhost', 'username' => '', 'password' => '', 'dbname' => '', 'system' => '', 'port' => '' ]
		];

		File::create('Configuration/database.json', Json::encode($array, 'JSON_PRETTY_PRINT'));
	}

	public static function dependencies()
    {
	    $array = [
            'analyzer' => 'LFW.Framework.Analyzer.Analyzer',
            'controller' => 'LFW.Framework.Controller.Controller',
            'form' => 'LFW.Framework.Forms.FormFactory',
            'getUrl' => 'LFW.Framework.Controller.GetUrl',
            'mail' => 'LFW.Framework.Mail.Mailer',
            'memcached' => 'LFW.Framework.Cache.MemCache',
            'microtime' => 'LFW.Framework.Utility.Microtime',
            'orm' => 'LFW.ORM.OrmFactory',
            'redirect' => 'LFW.Framework.Request.Redirect',
            'response' => 'LFW.Framework.Request.Response',
            'route' => 'LFW.Framework.Routing.RoutingFactory',
            'service' => 'LFW.Framework.Request.Service',
            'session' => 'LFW.Framework.Request.Session',
            'trad' => 'LFW.Framework.Controller.TraductionFactory',
            'twig' => 'LFW.Framework.Controller.View',
            'tel' => 'LFW.Framework.Controller.Templating'
        ];

        File::create('Configuration/dependencies.json', Json::encode($array, 'JSON_PRETTY_PRINT'));
    }

    public static function routing()
    {
        File::create('Configuration/routing.json', '{'."\n".'   '."\n".'}');
    }

    public static function service()
    {
        File::create('Configuration/service.json', '{'."\n".'   '."\n".'}');
    }

    public static function console()
    {
        $array = [
            'default' => [
                'Bundle:generate' => 'LFW.Console.Bundle.GenerateBundle',
                'Clear:Cache' => 'LFW.Console.Files.ClearCache',
                'Controller:generate' => 'LFW.Console.Bundle.GenerateController',
                'Documentation:create' => 'LFW.Console.Documentation.DocGen',
                'Framework:init' => 'LFW.Console.Framework.Init',
                'ORM:addentity' => 'LFW.Console.ORM.Addentity',
                'ORM:createdb' => 'LFW.Console.ORM.Createdb',
                'Test:Unit:run' => 'LFW.UnitTest.RunTest'
            ],
            'custom' => []
        ];

        File::create('Configuration/console.json', Json::encode($array, 'JSON_PRETTY_PRINT'));
    }
}