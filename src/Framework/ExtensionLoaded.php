<?php
namespace Frash\Framework;

/**
 * Class ExtensionLoaded
 * @package Frash\Framework
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