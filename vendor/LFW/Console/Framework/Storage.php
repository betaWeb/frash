<?php
namespace LFW\Console\Framework;
use LFW\Framework\FileSystem\Directory;
use LFW\Framework\FileSystem\File;

/**
 * Class Storage
 * @package LFW\Console\Framework
 */
class Storage{
    public static function preinstall()
    {
        if(!file_exists('Storage/')){
            echo 'Dossier Storage créé !'.PHP_EOL;
            Directory::create('Storage/', 0770);
        }
    }

    public static function cache(){
        if(!file_exists('Storage/Cache/')){
            Directory::create('Storage/Cache/', 0770);
        }

        File::create('Configuration/.htaccess', 'Deny from all');
    }

    public static function logs(){
        if(!file_exists('Storage/Logs/')){
            Directory::create('Storage/Logs/', 0770);
        }

        File::create('Configuration/.htaccess', 'Deny from all');
    }
}