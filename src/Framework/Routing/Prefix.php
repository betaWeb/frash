<?php
namespace Frash\Framework\Routing;

/**
 * Class Prefix
 * @package Frash\Framework\Routing
 */
class Prefix{
	/**
	 * @param string $script_name
	 * @return string
	 */
	public static function define(string $script_name): string{
		if($script_name == '/index.php'){
			return '/';
		} else {
			$expl = explode('/', ltrim($script_name, '/'));
			return '/'.$expl[0].'/';
		}
	}
}