<?php
	namespace LFW\DocGen\TreatmentSite;
    use LFW\Framework\FileSystem\Directory;

	class GenerationDoc{
		private static $output;

		public static function work($class){
            foreach($class as $c){
                $class = new \ReflectionClass($c);
                $name = str_replace('\\', '.', $c);

                $const = $class->getConstants();
                $prop = $class->getProperties();
                $method = $class->getMethods();
            }
		}

		private static function dir_exist($path){
			if(Directory::exist($path) === false){
                Directory::create($path, 0775);
            }
		}
	}