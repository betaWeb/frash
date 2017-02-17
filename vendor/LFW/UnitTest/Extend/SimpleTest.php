<?php
namespace LFW\UnitTest\Extend;

/**
 * Class SimpleTest
 * @package LFW\UnitTest\Extend
 */
abstract class SimpleTest{
	/**
	 * @var integer
	 */
	private $failure = 0;

	/**
	 * @var integer
	 */
	private $success = 0;

	/**
	 * @var integer
	 */
	private $nb_test = 0;

	/**
	 * @param string $variable
	 */
	abstract private function increment(string $variable){
		$this->$variable += 1;
	}

	/**
	 * @return object
	 */
	public function results(){
		return (object) [
			'failure' => $this->failure,
			'success' => $this->success,
			'nb_test' => $this->nb_test
		];
	}

	/**
	 * @param mixed $value
	 * @param mixed $function
	 * @return bool
	 */
	protected function checkEqual($value, $function){
		$this->increment('nb_test');

		if($value == $function){
			$this->increment('success');
			return true;
		} else {
			$this->increment('failure');
			return false;
		}
	}
}