<?php
	namespace LFW\Framework\FileSystem;

    /**
     * Class Directory
     * @package LFW\Framework\FileSystem
     */
	class Directory{
        /**
         * @param string $path
         * @param string $chmod
         */
		public static function create($path, $chmod){
			mkdir($path, $chmod);
		}

        /**
         * @param string $path
         * @return bool
         */
		public static function exist($path){
			if(file_exists($path)){
                return true;
            }
            else{
            	return false;
            }
		}
	}