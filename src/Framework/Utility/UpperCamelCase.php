<?php
namespace Frash\Framework\Utility;

/**
 * Class UpperCamelCase
 * @package Frash\Framework\Utility
 */
class UpperCamelCase{
	/**
     * @param string $str
     */
	private static $str = '';

    /**
     * @param string $string
     * @return string
     */
	public static function treatment(string $string): string{
		self::$str = ucfirst($string);
		self::recursive();

		return self::$str;
	}

	private static function recursive(){
		if(strstr(self::$str, '_')){
			$pos = strpos(self::$str, '_');
			$next = self::$str[ $pos + 1 ];
			
			if(ctype_alpha($next)){
				self::$str[ $pos + 1 ] = ucfirst($next);
				self::$str[ $pos ] = '';
			}

			if(strstr(self::$str, '_')){
				self::recursive();
			}
		}
	}
}