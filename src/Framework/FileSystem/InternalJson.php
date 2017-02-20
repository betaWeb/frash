<?php
namespace LFW\Framework\FileSystem;

/**
 * Class InternalJson
 * @package LFW\Framework\FileSystem
 */
class InternalJson extends Json{
    /**
     * @return array
     */
	public static function importConfig(): array{
		return self::decode(File::read('Configuration/config.json'));
	}

    /**
     * @return array
     */
    public static function importConsole(): array{
        return self::decode(File::read('Configuration/console.json'));
    }

    /**
     * @return array
     */
    public static function importDatabase(): array{
        return self::decode(File::read('Configuration/database.json'));
    }

    /**
     * @return array
     */
    public static function importDependencies(): array{
        return self::decode(File::read('Configuration/dependencies.json'));
    }

    /**
     * @return array
     */
    public static function importRouting(): array{
        return self::decode(File::read('Configuration/routing.json'));
    }

    /**
     * @return array
     */
    public static function importService(): array{
        return self::decode(File::read('Configuration/service.json'));
    }
}