<?php
	namespace LFW\DocGen\Treatment;
    use LFW\Framework\FileSystem\Directory;

	class DirExist{
		public static function verif($path){
			if(Directory::exist($path) === false){
                Directory::create($path, 0775);
            }
		}
	}