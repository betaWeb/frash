<?php
namespace Frash\Framework\Utility\Formatting;

/**
 * Class Collection
 * @package Frash\Framework\Utility\Formatting
 */
class Collection{
	/**
	 * @var array
	 */
	private $array = [];

    /**
     * Collection constructor.
     * @param array $array
     */
	public function __construct(array $array)
	{
		$this->array = $array;
	}

	/**
	 * @param string $get
	 * @return mixed
	 */
	public function get(string $get)
	{
		$arr = $this->array;
		$keys = explode('.', $get);

		foreach ($keys as $key) {
			if (is_object($arr)) {
				$arr = $arr->$key;
			} else if (is_array($arr)) {
				$arr = $arr[ $key ];
			} else {
				return null;
			}
		}

		return $arr;
	}

	/**
	 * @return mixed
	 */
	public function first()
	{
		$array = $this->array;
		return array_shift($array);
	}

	/**
	 * @param array $array
	 * @param string $interval
	 * @return array
	 */
	public function interval(string $interval): array
	{
		$return = [];

		if($interval[0] == ':'){
			$start = 0;
		} else {
			preg_match('/^(\d+)\:/', $interval, $match);
			$start = $match[1];
		}

		if(substr($interval, -1) == ':'){
			$end = count($this->array) - 1;
		} else {
			preg_match('/\:(\d+)$/', $interval, $match);
			$end = $match[1];
		}

		for($i = $start; $i <= $end; $i++){
			$return[] = $this->array[ $i ];
		}

		return $return;
	}

	/**
	 * @return mixed
	 */
	public function last()
	{
		$array = $this->array;
		return array_pop($array);
	}
}