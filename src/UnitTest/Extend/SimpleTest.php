<?php
namespace Frash\UnitTest\Extend;
use Frash\Framework\DIC\Dic;

/**
 * Class SimpleTest
 * @package Frash\UnitTest\Extend
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
	private function increment(string $variable){
		$this->$variable++;
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
	 * @return Dic
	 */
	public function dic(){
		return new Dic();
	}

	/**
	 * @param string $increment
	 * @param bool $return
	 * @return bool
	 */
	private function conclusion(string $increment, bool $return): bool{
		$this->increment($increment);
		return $return;
	}

	/**
	 * @param bool $bool
	 * @param mixed $function
	 * @return bool
	 */
	public function checkBoolean(bool $bool, $function): bool{
		$this->increment('nb_test');

		if($function === $bool){
			return $this->conclusion('success', true);
		} else {
			return $this->conclusion('failure', false);
		}
	}

	/**
	 * @param mixed $value
	 * @return bool
	 */
	protected function checkEmpty($value){
		$this->increment('nb_test');

		if(empty($value)){
			return $this->conclusion('success', true);
		} else {
			return $this->conclusion('failure', false);
		}
	}

	/**
	 * @param mixed $value
	 * @param mixed $function
	 * @return bool
	 */
	protected function checkEqual($value, $function): bool{
		$this->increment('nb_test');

		if($value == $function){
			return $this->conclusion('success', true);
		} else {
			return $this->conclusion('failure', false);
		}
	}

	/**
	 * @param mixed $value
	 * @param mixed $function
	 * @return bool
	 */
	protected function checkNotEmpty($value, $function): bool{
		$this->increment('nb_test');

		if(!empty($value)){
			return $this->conclusion('success', true);
		} else {
			return $this->conclusion('failure', false);
		}
	}
}