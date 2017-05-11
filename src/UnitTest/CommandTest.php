<?php
namespace Frash\UnitTest;
use Configuration\TestUnit;
use Frash\Console\CommandInterface;
use Frash\Framework\FileSystem\{ Directory, Json };
use Frash\Framework\Utility\Microtime;
use Frash\UnitTest\{ Flag, Run };

/**
 * Class CommandTest
 * @package Frash\UnitTest
 */
class CommandTest implements CommandInterface
{
	/**
	 * @var array
	 */
	private $class = '';

	/**
	 * @var array
	 */
	private $flag = [];

	/**
	 * @var object
	 */
	private $microtime;

	/**
	 * @var object
	 */
	private $history = [];

	/**
	 * CommandTest constructor.
	 * @param array $argv
	 */
	public function __construct(array $argv){
		if(!empty($argv[2])){
			$this->microtime = new Microtime;
			$this->microtime->set('start_unit_test');

			Directory::notExistAndCreate('Storage/');
			Directory::notExistAndCreate('Storage/rapports/');

			$this->flag = Flag::define($argv[2]);

			if($this->flag['option'] == '--one' && !empty($argv[3])){
				$this->class = $argv[3];
			}

			$this->history = (object) [ 'nb_test' => 0, 'success' => 0, 'failure' => 0 ];
		}
	}

	public function work(){
		if(!empty($this->flag)){
			if($this->flag['option'] == '--all'){
				$testunit = TestUnit::define();

				foreach($testunit as $class){
					$this->run(new $class);
				}
			} elseif($this->flag['option'] == '--one' && !empty($this->class)) {
				$class = TestUnit::define()[ $this->class ];
				$this->run(new $class);
			}

			$this->microtime->set('end_unit_test');

			echo 'Nombre de tests : '.$this->history->nb_test.PHP_EOL;
			echo 'Succès : '.$this->history->success.PHP_EOL;
			echo 'Fails : '.$this->history->failure.PHP_EOL.PHP_EOL;
			echo 'Temps d\'exécution : '.$this->microtime->getTiming('start_unit_test', 'end_unit_test').PHP_EOL;
		}
	}

	/**
	 * @param object $class
	 */
	private function run($class){
		$run = new Run($class);
		$result = $run->launch();

		$this->history->nb_test += $result->tests;
		$this->history->success += $result->success;
		$this->history->failure += $result->fails;
	}
}