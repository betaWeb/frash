<?php
namespace LFW\DocGen\Treatment;
use LFW\Framework\FileSystem\Directory;

/**
 * Class DirExist
 * @package LFW\DocGen\Treatment
 */
class DirExist{
	/**
	 * @param string $path
	 */
	public static function verif(string $path){
		if(Directory::exist($path) === false){
            Directory::create($path, 0775);
        }
	}
}