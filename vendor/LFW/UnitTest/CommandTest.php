<?php
namespace LFW\UnitTest;
use LFW\Console\CommandInterface;
use LFW\Framework\FileSystem\{ Directory, Json };
use LFW\UnitTest\{ Flag, Run };

/**
 * Class CommandTest
 * @package LFW\UnitTest
 */
class CommandTest implements CommandInterface
{
	const PREFIX = 'Storage/tests';

	/**
	 * @var array
	 */
	private $class = '';

	/**
	 * @var array
	 */
	private $flag = [];

	/**
	 * CommandTest constructor.
	 * @param array $argv
	 */
	public function __construct(array $argv){
		$this->dir_test('Storage/');
		$this->dir_test('Storage/rapports/');

		$this->flag = Flag::define($argv[2]);

		if($this->flag['option'] == '--one' && isset($argv[3])){
			$this->class = [ $argv[3] ];
		} elseif($this->flag['option'] == '--dir' && isset($argv[3])) {
			$iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(self::PREFIX.$argv[3]));

			foreach($iterator as $file){}
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
			$class = str_replace('.', '\\', $this->class);
			$this->run(new $class);
		} elseif($this->flag['option'] == '--dir') {}
	}

	/**
	 * @param object $class
	 */
	private function run($class){
		$run = new Run($class);
		$run->launch();
	}

	private function dir_test(string $dir){
		if(!Directory::exist($dir)){
			Directory::create($dir, 0770);
		}
	}
}