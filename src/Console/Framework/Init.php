<?php
namespace Frash\Console\Framework;
use Frash\Console\CommandInterface;
use Frash\Console\Bundle\CreateBundle;
use Frash\Console\Framework\{ Configuration, Storage };
use Frash\Framework\FileSystem\Directory;

/**
 * Class Init
 * @package Frash\Console\Framework
 */
class Init implements CommandInterface
{
	/**
     * Init constructor.
     * @param array $argv
     */
    public function __construct(array $argv){}

    public function work()
    {
        fwrite(STDOUT, 'Activation de l\'analyzer (yes/no) : ');
        $analyzer = (string) trim(fgets(STDIN));

        fwrite(STDOUT, 'Activation du cache de template (yes/no) : ');
        $cache = (string) trim(fgets(STDIN));

        fwrite(STDOUT, 'Langue par défaut (fr) : ');
        $default_lang = (string) trim(fgets(STDIN));

        fwrite(STDOUT, 'Langues disponibles (fr/en/de/...) : ');
        $dispo_lang = (string) trim(fgets(STDIN));

        fwrite(STDOUT, 'Log d\'access (yes/no) : ');
        $access_log = (string) trim(fgets(STDIN));

        fwrite(STDOUT, 'Log pour l\'ajax (yes/no) : ');
        $ajax_log = (string) trim(fgets(STDIN));

        fwrite(STDOUT, 'Log d\'error (yes/no) : ');
        $error_log = (string) trim(fgets(STDIN));

        fwrite(STDOUT, 'Log de request (yes/no) : ');
        $request_log = (string) trim(fgets(STDIN));

        fwrite(STDOUT, 'Nom du premier bundle (AppBundle) : ');
        $bundle = (string) trim(fgets(STDIN));

        CreateBundle::verifDirExist();
        CreateBundle::createDir($bundle);

        Directory::notExistAndCreate('public/');

        Configuration::preinstall();
        Configuration::htaccess();
        Configuration::config($analyzer, $cache, $default_lang, $dispo_lang, $access_log, $ajax_log, $error_log, $request_log);
        Configuration::database($bundle);
        Configuration::dependencies();
        Configuration::routing();
        Configuration::console();
        Configuration::service();
        Configuration::testunit();

        Storage::preinstall();
        Storage::cache();
        Storage::logs();
    }
}