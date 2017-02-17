<?php
namespace LFW\UnitTest;

/**
 * Class Flag
 * @package LFW\UnitTest
 */
class Flag{
	/**
	 * @var string
	 */
	private static $flag = '';

	/**
	 * @param string $flag
	 * @return array
	 */
	public static function define(string $flag){
		self::$flag = $flag;

		$array = [];
		$array['option'] = self::option();
		$array['rapport'] = self::rapport();
		$array['color'] = self::color();

		return $array;
	}

	/**
	 * @return string
	 */
	private static function option(){
		$options = [ '--one', '--dir', '--all' ];

		foreach($options as $opt){
			if(!empty(self::$flag) && strstr($opt, self::$flag)){
				self::$flag = str_replace($opt, '', self::$flag);
				return $opt;
			}
		}
	}

	/**
	 * @return bool
	 */
	private static function rapport(){
		if(!empty(self::$flag) && strstr('--rapport', self::$flag)){
			self::$flag = str_replace('--rapport', '', self::$flag);
			return true;
		}
	}

	/**
	 * @return bool
	 */
	private static function color(){
		if(!empty(self::$flag) && strstr('--color', self::$flag)){
			self::$flag = str_replace('--color', '', self::$flag);
			return true;
		}
	}
}