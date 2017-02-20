<?php
namespace LFW\Framework;

/**
 * Class ExtensionLoaded
 * @package LFW\Framework
 */
class ExtensionLoaded{
	/**
	 * @return bool
	 */
	public static function memcached(): bool{
		if(class_exists('Memcached')){
			return true;
		} else {
			return false;
		}
	}
}