<?php
namespace LFW\Framework\Request;
use LFW\Framework\DIC\Dic;
use LFW\Framework\FileSystem\InternalJson;

/**
 * Class Service
 * @package LFW\Framework\Request
 */
class Service{
	/**
	 * @var array
	 */
	private $services = [];

	/**
	 * @var array
	 */
	private $open = [];

	/**
	 * @param Dic $dic
	 */
	public function __construct(Dic $dic){
		$this->services = InternalJson::importService();
	}

	/**
	 * @param string $service
	 * @return object
	 */
	public function load(string $service){
		if(array_key_exists($service, $this->open)){
            return $this->open[ $key ];
        } elseif(array_key_exists($service, $this->services)) {
            $path = str_replace('.', '\\', $this->services[ $key ]);

            $class = new $path($this);
            $this->open[ $key ] = $class;

            return $class;
        }
	}
}