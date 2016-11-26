<?php
    namespace LFW\DocGen;

    /**
     * Class ListDirFiles
     * @package LFW\DocGen
     */
    class ListDirFiles{
        /**
         * @param string $path
         */
        public static function generation($path){
            $array = [];

            $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
            foreach($iterator as $file){
                $array[] = self::removePath($path, $file);
            }

            return $array;
        }

        /**
         * @param string $path
         * @param string $file
         * @return string
         */
        private static function removePath($path, $file){
            return str_replace($path.'/', '', $file);
        }
    }