<?php
namespace Frash\Console\Framework;
use Frash\Console\Answer;
use Frash\Console\Bundle\CreateBundle;
use Frash\Console\Framework\Install\{ Configuration, Storage, Traduction };
use Frash\Framework\FileSystem\Directory;

/**
 * Class LaunchCmdComposer
 * @package Frash\Console\Framework
 */
class LaunchCmdComposer
{
	public static function work()
	{
		$inspecter = Answer::define('Activation de l\'analyzer (yes/no) : ');
        $cache = Answer::define('Activation du cache de template (yes/no) : ');
        $default_lang = Answer::define('Langue par défaut (fr) : ');
        $dispo_lang = Answer::define('Langues disponibles (fr/en/de/...) : ');
        $bundle = Answer::define('Nom du premier bundle (AppBundle) : ');

        CreateBundle::verifDirExist();
        CreateBundle::createDir($bundle);

        Directory::notExistAndCreate('public/');
        Directory::notExistAndCreate('Traductions/');

        Configuration::preinstall();
        Configuration::htaccess();
        Configuration::config($inspecter, $cache, $default_lang, $dispo_lang);
        Configuration::database($bundle);
        Configuration::dependencies();
        Configuration::routing();
        Configuration::console();
        Configuration::service();
        Configuration::testunit();

        Storage::preinstall();
        Storage::cache();
        Storage::logs();

        Traduction::create($dispo_lang);
	}
}