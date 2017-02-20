<?php
namespace LFW\UnitTest;

/**
 * Class Methods
 * @package LFW\UnitTest
 */
class Methods{
	/**
	 * @param object $class
	 * @return array
	 */
	public static function test($class){
		$reflect = new \ReflectionClass($class);
		$parent_methods = self::parent($reflect);

		$test_methods = $reflect->getMethods();
		$methods = [];

		foreach($test_methods as $tm){
			$methods[ $tm->name ] = $tm->class;
		}

		unset($methods['__construct']);
		foreach($parent_methods as $pm){
			unset($methods[ $pm ]);
		}

		return $methods;
	}

	/**
	 * @param object $reflect
	 * @return array
	 */
	private static function parent($reflect){
		$parent = $reflect->getParentClass()->getMethods();
		$methods = [];

		foreach($parent as $m){
			$methods[] = $m->name;
		}

		return $methods;
	}
}