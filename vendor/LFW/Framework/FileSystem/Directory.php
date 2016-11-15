<?php
	namespace LFW\Framework\FileSystem;

	class Directory{
		public static function create($path, $chmod){
			mkdir($path, $chmod);
		}

		public static function exist($path){
			if(file_exists($path)){
                return true;
            }
            else{
            	return false;
            }
		}
	}