<?php
namespace Frash\Framework\Request\Service;
use Frash\Framework\DIC\Dic;

/**
 * Class Service
 * @package Frash\Framework\Request\Service
 */
class Service
{
	/**
	 * @var Dic
	 */
	private $dic;

	/**
	 * @var array
	 */
	private $open = [];

	/**
	 * @var array
	 */
	private $services = [];

	/**
	 * @param Dic $dic
	 */
	public function __construct(Dic $dic)
	{
		$this->dic = $dic;
		$this->services = $this->dic->service['service'];
	}

	/**
	 * @param string $service
	 * @return object
	 */
	public function load(string $service)
	{
		if(array_key_exists($service, $this->open)){
            return $this->open[ $service ];
        } elseif(array_key_exists($service, $this->services)) {
        	if(!strstr($this->services[ $service ], '@')){
        		return $this->dic->load('exception')->publish('Missing bundle before service '.$service);
        	}

        	list($bundle, $class) = explode('@', $this->services[ $service ]);
            $path = 'Bundles\\'.$bundle.'\Service\\'.$class;

            $class = new $path($this->dic);
            $this->open[ $service ] = $class;

            return $class;
        }
	}
}