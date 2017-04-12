<?php
namespace Frash\Console\Framework\Install;
use Frash\Framework\FileSystem\{ Directory, File };

/**
 * Class Storage
 * @package Frash\Console\Framework\Install
 */
class Storage{
    public static function preinstall(){
        Directory::notExistAndCreate('Storage/');
    }

    public static function cache(){
        Directory::notExistAndCreate('Storage/Cache/');
        File::create('Configuration/.htaccess', 'Deny from all');
    }

    public static function logs(){
        Directory::notExistAndCreate('Storage/Logs/');
        File::create('Configuration/.htaccess', 'Deny from all');
    }
}