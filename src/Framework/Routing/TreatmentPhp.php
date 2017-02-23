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
		if(!empty($params['middleware'])){
			$this->waiting['middleware'][] = $params['middleware'];
		}

		if(!empty($params['bundle'])){
			$this->waiting['bundle'] = $params['bundle'];
		}

		$function();

		if(!empty($params['middleware'])){
			array_pop($this->waiting['middleware']);
		}

		if(!empty($params['bundle'])){
			unset($this->waiting['bundle']);
		}
	}

	/**
	 * @param string $route
	 * @param string $path
	 * @param array $params
	 */
	protected function get(string $route, string $path, array $params = []){
		if(!empty($this->waiting['middleware']) || !empty($this->waiting['bundle'])){
			$middlewares = [];

			foreach($this->waiting['middleware'] as $m){
				$middlewares[] = $m;
			}

			$new_path = (!empty($this->waiting['bundle'])) ? $this->waiting['bundle'].':'.$path : $path;
			$this->get[ $route ] = [ 'path' => $new_path, 'params' => $params, 'middleware' => $middlewares ];
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
		if(!empty($this->waiting['middleware']) || !empty($this->waiting['bundle'])){
			$middlewares = [];

			foreach($this->waiting['middleware'] as $m){
				$middlewares[] = $m;
			}

			$new_path = (!empty($this->waiting['bundle'])) ? $this->waiting['bundle'].':'.$path : $path;
			$this->post[ $route ] = [ 'path' => $new_path, 'params' => $params, 'middleware' => $middlewares ];
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