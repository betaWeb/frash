<?php
	namespace LFW\Framework\FileSystem;

	class File{
		public static function exist($path){
			if(file_exists($path)){
                return true;
            }
            else{
            	return false;
            }
		}
	}