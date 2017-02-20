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
	public function show(string $trad): string{
        return $this->$trad;
    }
}