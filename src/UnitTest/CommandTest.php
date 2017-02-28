<?php
namespace Frash\UnitTest;
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
	const PREFIX = 'Storage/tests';

	/**
	 * @var array
	 */
	private $class = '';

	/**
	 * @var string
	 */
	private $dir = '';

	/**
	 * @var array
	 */
	private $flag = [];

	/**
	 * @var object
	 */
	private $microtime;

	/**
	 * CommandTest constructor.
	 * @param array $argv
	 */
	public function __construct(array $argv){
		$this->microtime = new Microtime;
		$this->microtime->set('start_unit_test');

		Directory::notExistAndCreate('Storage/');
		Directory::notExistAndCreate('Storage/rapports/');

		$this->flag = Flag::define($argv[2]);

		if($this->flag['option'] == '--one' && isset($argv[3])){
			if(substr($argv[3], -4) == '.php'){
				$class = str_replace('/', '\\', $file);
				$class = str_replace('.php', '', $class);

				$this->class = 'Storage\tests\\'.$class;
			} else {
				$this->class = 'Storage\tests\\'.$argv[3];
			}
		} elseif($this->flag['option'] == '--dir' && isset($argv[3])) {
			$this->dir = $argv[3];
		}
	}

	public function work(){
		if($this->flag['option'] == '--all'){
			$iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(self::PREFIX.'/'));

			foreach($iterator as $file){
				if(substr($file, -2) != '..' && substr($file, -1) != '.'){
					$class = str_replace('/', '\\', $file);
					$class = str_replace('.php', '', $class);

					$this->run(new $class);
				}
			}
		} elseif($this->flag['option'] == '--one') {
			$this->run(new $this->class);
		} elseif($this->flag['option'] == '--dir') {
			$iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(self::PREFIX.'/'.$this->dir));

			foreach($iterator as $file){
				if(substr($file, -2) != '..' && substr($file, -1) != '.'){
					$class = str_replace('/', '\\', $file);
					$class = str_replace('.php', '', $class);

					$this->run(new $class);
				}
			}
		}
	}

	/**
	 * @param object $class
	 */
	private function run($class){
		$run = new Run($class);
		$run->launch();

		$this->microtime->set('end_unit_test');
		echo 'Temps d\'exécution : '.$this->microtime->getTiming('start_unit_test', 'end_unit_test').PHP_EOL;
	}
}