<?php
namespace Frash\Framework\Routing;

/**
 * Class TreatmentPhp
 * @package Frash\Framework\Routing
 */
class TreatmentPhp{
	/**
	 * @var array
	 */
	private $get = [];

	/**
	 * @var array
	 */
	private $post = [];

	/**
	 * @var array
	 */
	private $waiting = [];

	/**
	 * @param array $params
	 * @param callable $function
	 */
	protected function group(array $params, callable $function){
		$this->waiting['middleware'][] = $params['middleware'];

		$function();

		array_pop($this->waiting['middleware']);
	}

	/**
	 * @param string $route
	 * @param string $path
	 * @param array $params
	 */
	protected function get(string $route, string $path, array $params = []){
		if(!empty($this->waiting['middleware'])){
			$middlewares = [];

			foreach($this->waiting['middleware'] as $m){
				$middlewares[] = $m;
			}

			$this->get[ $route ] = [ 'path' => $path, 'params' => $params, 'middleware' => $middlewares ];
		} else {
			$this->get[ $route ] = [ 'path' => $path, 'params' => $params ];
		}
	}

	/**
	 * @param string $route
	 * @param string $path
	 * @param array $params
	 */
	protected function post(string $route, string $path, array $params = []){
		if(!empty($this->waiting['middleware'])){
			$middlewares = [];

			foreach($this->waiting['middleware'] as $m){
				$middlewares[] = $m;
			}

			$this->post[ $route ] = [ 'path' => $path, 'params' => $params, 'middleware' => $middlewares ];
		} else {
			$this->post[ $route ] = [ 'path' => $path, 'params' => $params ];
		}
	}

	/**
	 * @param string $list
	 * @return array
	 */
	public function list(string $list): array{
		return $this->$list;
	}
}