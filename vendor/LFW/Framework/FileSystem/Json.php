<?php
	namespace LFW\Framework\FileSystem;

    /**
     * Class Json
     * @package LFW\Framework\FileSystem
     */
	class Json{
        const CONFIG = 'Configuration/config.json';
        const DATABASE = 'Configuration/database.json';
        const DEPEND = 'Configuration/dependencies.json';

        /**
         * @return array
         */
		public static function importConfigArray(): array{
			return json_decode(file_get_contents(self::CONFIG), true);
		}

        /**
         * @return object
         */
		public static function importConfigObject(){
			return json_decode(file_get_contents(self::CONFIG));
		}

        /**
         * @return array
         */
        public static function importDatabaseArray(): array{
            return json_decode(file_get_contents(self::DATABASE), true);
        }

        /**
         * @return object
         */
        public static function importDatabaseObject(){
            return json_decode(file_get_contents(self::DATABASE));
        }

        /**
         * @return array
         */
        public static function importDependenciesArray(): array{
            return json_decode(file_get_contents(self::DEPEND), true);
        }

        /**
         * @param string $routing
         * @return array
         */
        public static function importRoutingArray(string $routing): array{
            return json_decode(file_get_contents('Configuration/'.$routing.'.json'), true);
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
         * @return array
         */
        public static function decode(string $json): array{
            return json_decode($json);
        }
	}