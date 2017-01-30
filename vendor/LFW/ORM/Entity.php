<?php
namespace LFW\ORM;

/**
 * Class Entity
 * @package LFW\ORM
 */
class Entity{
	/**
	 * @var int
	 */
	protected $number_result;

	/**
	 * @var string
	 */
	protected $primary_key = 'id';

	/**
	 * @param string $column
	 */
	public function __get(string $column){
		return $this->$column;
	}

	/**
	 * @param string $column
	 * @param mixed $value
	 */
	public function __set(string $column, $value){
		$this->$column = $value;
	}
}