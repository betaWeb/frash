<?php
namespace Frash\Framework\FileSystem;

/**
 * Class File
 * @package Frash\Framework\FileSystem
 */
class File{
    /**
     * @param string $path
     * @param string $value
     */
    public static function create(string $path, string $value){
        file_put_contents($path, $value);
    }

    /**
     * @param string $path
     */
    public static function delete(string $path){
        unlink($path);
    }

    /**
     * @param string $path
     * @return bool
     */
	public static function exist(string $path): bool{
		if(file_exists($path)){
            return true;
        } else {
        	return false;
        }
	}

    /**
     * @param string $path
     * @return string
     */
    public static function read(string $path): string{
        return file_get_contents($path);
    }

    /**
     * @param string $file
     * @return int
     */
    public static function size(string $file): int{
        return filesize($file);
    }
}