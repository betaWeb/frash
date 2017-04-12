<?php
namespace Frash\Console\Framework\Install;
use Frash\Console\Framework\Install\Configuration\{ Configuration as Conf, Console, Database, Dependencies, Routing, Service, TestUnit };
use Frash\Framework\FileSystem\{ Directory, File, Json };

/**
 * Class Configuration
 * @package Frash\Console\Framework\Install
 */
class Configuration{
    public static function preinstall(){
        Directory::notExistAndCreate('Configuration/');
    }

    public static function htaccess(){
        File::create('Configuration/.htaccess', 'Deny from all');
    }

    /**
     * @param string $analyzer
     * @param string $cache
     * @param string $default_lang
     * @param string $dispo_lang
     */
	public static function config(string $analyzer, string $cache, string $default_lang, string $dispo_lang)
    {
		File::create('Configuration/Config.php', Conf::file($analyzer, $cache, $default_lang, $dispo_lang));
	}

    /**
     * @param string $bundle
     */
	public static function database(string $bundle)
    {
		File::create('Configuration/Database.php', Database::file($bundle));
	}

	public static function dependencies()
    {
        File::create('Configuration/Dependencies.php', Dependencies::file());
    }

    public static function routing()
    {
        File::create('Configuration/Routing.php', Routing::file());
    }

    public static function service()
    {
        File::create('Configuration/Service.php', Service::file());
    }

    public static function testunit()
    {
        File::create('Configuration/TestUnit.php', TestUnit::file());
    }

    public static function console()
    {
        File::create('Configuration/Console.php', Console::file());
    }
}