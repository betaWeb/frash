<?php
    namespace LFW\DocGen;

    /**
     * Class TreatmentClass
     * @package LFW\DocGen
     */
    class TreatmentClass{
        /**
         * @var array
         */
        private static $class = [];

        /**
         * @param array $list
         */
        public static function generationClass($list){
            foreach($list as $l){
                $namespace = str_replace('vendor/', '', $l);
                $namespace = str_replace('/', '\\', $namespace);
                $namespace = str_replace('.php', '', $namespace);

                self::$class[] = $namespace;
            }
        }

        public static function getClass(){
            return self::$class;
        }
    }