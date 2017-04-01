<?php
namespace Frash\Framework\Utility;

/**
 * Class Microtime
 * @package Frash\Framework\Utility
 */
class Microtime{
    /**
     * @var array
     */
	private $microtime = [];

    /**
     * @param string $name
     * @param integer $value
     */
	public function set(string $name, int $value = 0){
        $this->microtime[ $name ] = ($value == 0) ? microtime(true) * 1000 : $value;
	}

    /**
     * @param string $start
     * @param string $end
     * @return double
     */
	public function getTiming(string $start, string $end): float{
		return substr($this->microtime[ $end ] - $this->microtime[ $start ], 0, 5);
	}
}