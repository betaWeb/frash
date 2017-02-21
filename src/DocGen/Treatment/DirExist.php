<?php
namespace Frash\DocGen\Treatment;
use Frash\Framework\FileSystem\Directory;

/**
 * Class DirExist
 * @package Frash\DocGen\Treatment
 */
class DirExist{
	/**
	 * @param string $path
	 */
	public static function verif(string $path){
        Directory::notExistAndCreate($path);
	}
}