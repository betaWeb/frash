<?php
namespace Frash\Framework;

/**
 * Class TraductionParent
 * @package Frash\Framework
 */
class TraductionParent{
    /**
     * @param string $trad
     * @return string
     */
	public function __get(string $trad): string{
        return $this->$trad;
    }
}