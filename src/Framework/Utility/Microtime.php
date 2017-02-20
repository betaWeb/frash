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
     */
	public function set(string $name){
		$this->microtime[ $name ] = microtime(true) * 1000;
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