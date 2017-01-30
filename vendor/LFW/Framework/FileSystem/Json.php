<?php
namespace LFW\Framework\FileSystem;
use LFW\Framework\FileSystem\File;

/**
 * Class Json
 * @package LFW\Framework\FileSystem
 */
class Json{
    const CONFIG = 'Configuration/config.json';
    const CONSOLE = 'Configuration/console.json';
    const DATABASE = 'Configuration/database.json';
    const DEPEND = 'Configuration/dependencies.json';
    const ROUTING = 'Configuration/routing.json';
    const TEST = 'Configuration/test_unit.json';

    /**
     * @return array
     */
	public static function importConfig(): array{
		return self::decode(File::read(self::CONFIG));
	}

    /**
     * @return array
     */
    public static function importConsole(): array{
        return self::decode(File::read(self::CONSOLE));
    }

    /**
     * @return array
     */
    public static function importDatabase(): array{
        return self::decode(File::read(self::DATABASE));
    }

    /**
     * @return array
     */
    public static function importDependencies(): array{
        return self::decode(File::read(self::DEPEND));
    }

    /**
     * @param string $routing
     * @return array
     */
    public static function importRouting(): array{
        return self::decode(File::read(self::ROUTING));
    }

    /**
     * @return array
     */
    public static function importTestUnit(): array{
        return self::decode(File::read(self::TEST));
    }

    /**
     * @param mixed $json
     * @return string
     */
    public static function encode($json): string{
        return json_encode($json);
    }

    /**
     * @param string $json
     * @return array|object
     */
    public static function decode(string $json, string $object = 'false'){
        if($object == 'false'){
            return json_decode($json, true);
        } elseif($object == 'true') {
            return json_decode($json);
        }
    }
}