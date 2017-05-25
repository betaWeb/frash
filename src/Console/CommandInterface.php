<?php
namespace Frash\Console;

/**
 * Interface CommandInterface
 * @package Frash\Console
 */
interface CommandInterface{
	public function __construct(array $argv);
	public function work();
}