<?php
	namespace LFW\Framework\FileSystem;

    /**
     * Class File
     * @package LFW\Framework\FileSystem
     */
	class File{
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