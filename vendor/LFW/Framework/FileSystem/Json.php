<?php
	namespace LFW\Framework\FileSystem;
    use LFW\Framework\FileSystem\File;

    /**
     * Class Json
     * @package LFW\Framework\FileSystem
     */
	class Json{
        const CONFIG = 'Configuration/config.json';
        const DATABASE = 'Configuration/database.json';
        const DEPEND = 'Configuration/dependencies.json';
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
        public static function importDatabaseArray(): array{
            return self::decode(File::read(self::DATABASE));
        }

        /**
         * @return object
         */
        public static function importDatabaseObject(){
            return self::decode(File::read(self::DATABASE), 'true');
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
        public static function importRouting(string $routing): array{
            return self::decode(File::read('Configuration/'.$routing.'.json'));
        }

        /**
         * @return array
         */
        public static function importTestUnit(): array{
            return self::decode(File::read(self::TEST));
        }

        /**
         * @param array $json
         * @return string
         */
        public static function encode(array $json): string{
            return json_encode($json);
        }

        /**
         * @param string $json
         * @return array|object
         */
        public static function decode(string $json, string $object = 'false'){
            if($object == 'false'){
                return json_decode($json, true);
            }
            elseif($object == 'true'){
                return json_decode($json);
            }
        }
	}