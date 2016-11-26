<?php
    namespace LFW\DocGen;
    use LFW\Framework\FileSystem\Directory;
    use LFW\Framework\FileSystem\File;

    /**
     * Class TreatmentFiles
     * @package LFW\DocGen
     */
    class TreatmentFiles{
        /**
         * @var string
         */
        private static $format;

        /**
         * @var string
         */
        private static $output;

        /**
         * @var array
         */
        private static $class = [];

        /**
         * @param string $output
         */
        public static function setParams($output, $format){
            self::$format = $format;
            self::$output = $output;
        }

        /**
         * @param array $list
         */
        public static function generationClass($list){
            foreach($list as $l){
                $namespace = str_replace('vendor/', '', $l);
                $namespace = str_replace('LFW-Documentor', 'LFWD', $namespace);
                $namespace = str_replace('/', '\\', $namespace);
                $namespace = str_replace('.php', '', $namespace);

                self::$class[] = $namespace;
            }
        }

        public static function defineClass(){
            if(self::$format == 'HTML'){}
            elseif(self::$format == 'site'){
                if(Directory::exist(self::$output) === false){
                    Directory::create(self::$output, 0775);
                }

                foreach(self::$class as $c){
                    $class = new \ReflectionClass($c);
                    $name = str_replace('\\', '.', $c);

                    $const = $class->getConstants();
                    $prop = $class->getProperties();
                    $method = $class->getMethods();
                }
            }
        }
    }