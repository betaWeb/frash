<?php
namespace Frash\Framework\Exception;

/**
 * Class Debug
 * @package Frash\Framework\Exception
 */
class Debug{
	/**
	 * @param mixed $value
	 */
	public static function dump($value){
		print_r($value);
	}

	/**
	 * @param mixed $value
	 */
	public static function predump($value){
		echo '<pre>'; print_r($value); echo '</pre>';
	}
}