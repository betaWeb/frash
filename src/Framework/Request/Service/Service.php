<?php
namespace Frash\Framework\Request\Service;
use Frash\Framework\DIC\Dic;

/**
 * Class Service
 * @package Frash\Framework\Request\Service
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
		$this->services = $dic->get('conf')['service'];
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