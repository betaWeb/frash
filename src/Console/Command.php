<?php
namespace Frash\Console;
use Frash\Framework\DIC\Dic;
use Frash\Framework\FileSystem\InternalJson;

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
	 * @var boolean
	 */
	private $custom = false;

    /**
     * Command constructor.
     * @param array $argv
     */
	public function __construct(array $argv){
		$this->argv = $argv;

		$dic = new Dic();
		$this->conf = $dic->get('conf')['console'];

		if($argv[1] == '--a'){
            $this->isCustom();
        }
	}

	public function isCustom(){
		$this->custom = true;
	}

	public function work(){
		if($this->custom === true){
			$path = str_replace('.', '\\', $this->conf['custom'][ $this->argv[2] ]);
		} else {
			$path = str_replace('.', '\\', $this->conf['default'][ $this->argv[1] ]);
		}

		$cmd = new $path($this->argv);
		$cmd->work();
	}
}