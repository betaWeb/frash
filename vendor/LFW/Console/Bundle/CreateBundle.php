<?php
namespace LFW\Console\Bundle;
use LFW\Framework\FileSystem\Directory;

class CreateBundle{
	const CHMOD = 0770;
	const PREFIX = 'Bundles/';

	public static function verifDirExist(){
		Directory::notExistAndCreate(self::PREFIX);
	}

	public static function createDir($name){
		Directory::create(self::PREFIX.$name, self::CHMOD);
        Directory::create(self::PREFIX.$name.'/Controllers', self::CHMOD);
        Directory::create(self::PREFIX.$name.'/Entity', self::CHMOD);
        Directory::create(self::PREFIX.$name.'/Entity/Mapping', self::CHMOD);
        Directory::create(self::PREFIX.$name.'/Service', self::CHMOD);
        Directory::create(self::PREFIX.$name.'/Requests', self::CHMOD);
        Directory::create(self::PREFIX.$name.'/Ressources', self::CHMOD);
        Directory::create(self::PREFIX.$name.'/Views', self::CHMOD);

        echo 'Bundle '.$name.' généré !'.PHP_EOL;
	}
}