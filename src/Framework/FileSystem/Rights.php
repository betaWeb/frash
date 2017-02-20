<?php
namespace LFW\Framework\FileSystem;

/**
 * Class Rights
 * @package LFW\Framework\FileSystem
 */
class Rights{
    /**
     * @param string $chmod
     * @param string $option
     * @param string $path
     */
	public static function chmod(string $chmod, string $option = '', string $path){
		chmod($path, $chmod);
	}

    /**
     * @param string $chmod
     * @param string $user
     */
	public static function chown(string $path, string $user){
		chown($path, $user.':www-data');
	}
}