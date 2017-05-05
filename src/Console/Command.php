<?php
namespace Frash\Console;
use Frash\Framework\DIC\Dic;

/**
 * Class Command
 * @package Frash\Console
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
     * Command constructor.
     * @param array $argv
     */
	public function __construct(array $argv){
		$this->argv = $argv;

		$dic = new Dic('console');
		$dic->preloading();

		$this->conf = $dic->console;
	}

	public function work(){
		if($this->argv[1] == '--a'){
			$path = str_replace('.', '\\', $this->conf['custom'][ $this->argv[2] ]);
		} else {
			$path = str_replace('.', '\\', $this->conf['default'][ $this->argv[1] ]);
		}

		$cmd = new $path($this->argv);
		$cmd->work();
	}
}