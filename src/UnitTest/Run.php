<?php
namespace Frash\UnitTest;
use Frash\UnitTest\Methods;

/**
 * Class Run
 * @package Frash\UnitTest
 */
class Run{
	/**
	 * @var object
	 */
	private $class;

	/**
	 * @var array
	 */
	private $methods = [];

	/**
	 * Run constructor.
	 * @param object $class
	 */
	public function __construct($class){
		$this->class = $class;
		$this->methods = Methods::test($this->class);
	}

	public function launch(){
		foreach($this->methods as $m => $c){
			$this->class->$m();
		}

		$results = $this->class->results();

		return (object) [
			'tests' => $results->nb_test,
			'success' => $results->success,
			'fails' => $results->failure
		];
	}
}