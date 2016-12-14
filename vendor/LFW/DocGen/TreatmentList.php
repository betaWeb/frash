<?php
    namespace LFW\DocGen;

    /**
     * Class TreatmentList
     * @package LFW\DocGen
     */
    class TreatmentList{
        /**
         * @var array
         */
        private static $exceptions = [
            '.git', '.idea', 'README.md', '.htaccess', '.htpasswd', 'vendor/twig', 'vendor/LFW/Cache', 'console.php', 'index.php',
            'vendor/autoload.php', 'vendor/composer', 'vendor/LFW/Console/listcommand.php'
        ];

        /**
         * @var array
         */
        private static $except_def = [];

        /**
         * @var array
         */
        private static $list = [];

        /**
         * @param array $except
         */
        public static function setExcept($except = []){
            self::$except_def = (empty($except)) ? [] : explode(';', $except);
        }

        /**
         * @param string $list
         */
        public static function removeExcept($list){
            self::$list = $list;

            $count_for = count($list) - 1;
            for($i = 0; $i <= $count_for; $i++){
                self::defineNewList($list[ $i ], $i);
            }

            return self::$list;
        }

        /**
         * @param string $path
         * @param int $current
         */
        private static function defineNewList($path, $current){
            $except = (!empty(self::$except_def)) ? array_merge(self::$exceptions, self::$except_def) : self::$exceptions;
            $count_for = count($except) - 1;

            for($i = 0; $i <= $count_for; $i++){
                if(strstr($path, $except[ $i ]) !== false ||
                    substr($path, -2) == '..' || substr($path, -1) == '.' ||
                    substr($path, -4) != '.php'
                ){
                    unset(self::$list[ $current ]);
                    break;
                }
            }
        }
    }