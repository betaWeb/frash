<?php
namespace LFW\Console\Framework;
use LFW\Console\CommandInterface;
use LFW\Console\Bundle\CreateBundle;
use LFW\Console\Framework\Configuration;
use LFW\Console\Framework\Storage;
use LFW\Framework\FileSystem\Directory;

/**
 * Class Init
 * @package LFW\Console\Framework
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
    	fwrite(STDOUT, 'Format du routing (json/php) : ');
        $format_routing = (string) trim(fgets(STDIN));

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

        fwrite(STDOUT, 'Log d\'error (yes/no) : ');
        $error_log = (string) trim(fgets(STDIN));

        fwrite(STDOUT, 'Log de request (yes/no) : ');
        $request_log = (string) trim(fgets(STDIN));

        fwrite(STDOUT, 'Nom du premier bundle (AppBundle) : ');
        $bundle = (string) trim(fgets(STDIN));

        CreateBundle::verifDirExist();
        CreateBundle::createDir($bundle);

        Configuration::preinstall();
        Configuration::htaccess();
        Configuration::config($format_routing, $analyzer, $cache, $default_lang, $dispo_lang, $access_log, $error_log, $request_log);
        Configuration::database($bundle);
        Configuration::dependencies();
        Configuration::routing();
        Configuration::console();
        Configuration::service();

        Storage::preinstall();
        Storage::cache();
        Storage::logs();
    }
}