<?php
namespace LFW\Console;

/**
 * Interface CommandInterface
 * @package LFW\Console
 */
interface CommandInterface{
	public function __construct(array $argv);
	public function work();
}