<?php
namespace Frash\Console\Framework;
use Frash\Console\Answer;
use Frash\Console\Bundle\CreateBundle;
use Frash\Console\Framework\Install\{ Configuration, Storage, Traduction };
use Frash\Framework\FileSystem\{ Directory, File, Json };

/**
 * Class LaunchCmdComposer
 * @package Frash\Console\Framework
 */
class LaunchCmdComposer
{
	public static function work()
	{
        $package = self::definePackage();

        if($package == 'alixsperoza/frash'){
            $inspecter = Answer::define('Activation de l\'inspecter (yes/no) : ');
            $default_lang = Answer::define('Langue par défaut (fr) : ');
            $dispo_lang = Answer::define('Langues disponibles (fr/en/de/...) : ');
            $cache = Answer::define('Activation du cache de template (yes/no) : ');
            $bundle = Answer::define('Nom du premier bundle (AppBundle) : ');

            CreateBundle::verifDirExist();
            CreateBundle::createDir($bundle);

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
            Traduction::create($dispo_lang);
        }

        Directory::notExistAndCreate('public/');

        Storage::preinstall();
        Storage::cache();
        Storage::logs();
	}

    /**
     * @return string
     */
    public static function definePackage(): string
    {
        $composer = Json::decode(File::read('composer.json'));
        $packages = [ 'alixsperoza/frash-cms' ];

        foreach($composer['require'] as $package => $version){
            if(in_array($package, $packages)){
                return $package;
            }
        }

        return 'alixsperoza/frash';
    }
}