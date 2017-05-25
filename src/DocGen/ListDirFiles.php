<?php
namespace Frash\DocGen;

/**
 * Class ListDirFiles
 * @package Frash\DocGen
 */
class ListDirFiles{
    /**
     * @param string $path
     * @return array
     */
    public static function generation(string $path): array{
        $array = (array) [];
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));

        foreach($iterator as $file){
            $array[] = self::removePath($path, $file);
        }

        return $array;
    }

    /**
     * @param string $path
     * @param string $file
     * @return string
     */
    private static function removePath(string $path, string $file): string{
        return str_replace($path.'/', '', $file);
    }
}