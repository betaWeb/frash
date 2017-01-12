<?php
	namespace LFW\UnitTest;
    use LFW\Console\CommandInterface;
    use LFW\Framework\FileSystem\Json;

    /**
     * Class RunTest
     * @package LFW\UnitTest
     */
	class RunTest implements CommandInterface{
		/**
		 * @var string
		 */
		private $class = '';

		/**
		 * @var string
		 */
		private $flag = '';

        /**
         * RunTest constructor.
         * @param array $argv
         * @param string $pwd
         */
		public function __construct(array $argv){
			$this->flag = $argv[2];

			if($this->flag == '--one'){
				$this->class = $argv[3];
			}
		}

		public function work(){
			if($this->flag == '--all'){
				$list = Json::importTestUnit();

				foreach($list as $path => $route){
					$class = str_replace('.', '\\', $path);
					$this->run(new $class);
				}
			}
			elseif($this->flag == '--one'){
				$class = str_replace('.', '\\', $this->class);
				$this->run(new $class);
			}
		}

		/**
		 * @param object $class
		 */
		private function run($class){}
	}