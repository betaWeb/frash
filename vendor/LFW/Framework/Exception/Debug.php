<?php
namespace LFW\Framework\Exception;

/**
 * Class Debug
 * @package LFW\Framework\Exception
 */
class Debug{
	public static function dump($array){
		print_r($array);
	}

	public static function predump($array){
		echo '<pre>'; print_r($array); echo '</pre>';
	}
}