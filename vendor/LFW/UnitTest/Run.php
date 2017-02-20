<?php
namespace LFW\UnitTest;
use LFW\UnitTest\Methods;

/**
 * Class Run
 * @package LFW\UnitTest
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
		echo 'Nombre de tests : '.$results->nb_test.PHP_EOL;
		echo 'Succès : '.$results->success.PHP_EOL;
		echo 'Fails : '.$results->failure.PHP_EOL.PHP_EOL;
	}
}