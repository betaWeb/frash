<?php
	namespace LFW\Console;
	use LFW\Framework\FileSystem\Json;

    /**
     * Class Command
     * @package LFW\Console
     */
	class Command{
		/**
		 * @var array
		 */
		private $argv = [];

		/**
		 * @var array
		 */
		private $conf = [];

		/**
		 * @var boolean
		 */
		private $custom = false;

        /**
         * Command constructor.
         * @param array $argv
         */
		public function __construct(array $argv){
			$this->argv = $argv;
			$this->conf = Json::importConsole();

			if($argv[1] == '--a'){
	            $this->isCustom();
	        }
		}

		public function isCustom(){
			$this->custom = true;
		}

		public function work(){
			if($this->custom === true){}
			else{
				$path = str_replace('.', '\\', $this->conf['default'][ $this->argv[1] ]);

				$cmd = new $path($this->argv);
				$cmd->work();
			}
		}
	}