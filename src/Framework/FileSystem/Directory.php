<?php
namespace Frash\Framework\FileSystem;
use Frash\Framework\FileSystem\File;

/**
 * Class Directory
 * @package Frash\Framework\FileSystem
 */
class Directory{
    /**
     * @param string $path
     * @param string $chmod
     */
	public static function create(string $path, string $chmod){
		mkdir($path, $chmod);
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
     * @param string $dir
     */
    public static function notExistAndCreate(string $dir){
        if(!self::exist($dir)){
            self::create($dir, 0770);
        }
    }

    /**
     * @param string $path
     */
    public static function delete(string $path){
        $dir_content = scandir($path);

        if($dir_content !== FALSE){
            foreach($dir_content as $entry){
                if(!in_array($entry, [ '.', '..' ])){
                    $entry = $path.'/'.$entry;

                    if(!is_dir($entry)){
                        File::delete($entry);
                    } else {
                        self::delete($entry);
                    }
                }
            }
        }

        rmdir($path);
    }

    /**
     * @param string $path
     * @return array
     */
    public static function listFiles(string $path): array{
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
        $files = [];

        foreach($iterator as $file){
            $files[] = $file;
        }

        return $files;
    }
}