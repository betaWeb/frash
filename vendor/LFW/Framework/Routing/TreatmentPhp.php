<?php
namespace LFW\Framework\Routing;

class TreatmentPhp{
	private $get = [];
	private $post = [];

	private $waiting = [];

	protected function group(array $params, callable $function){
		$this->waiting['middleware'][] = $params['middleware'];

		$function();

		array_pop($this->waiting['middleware']);
	}

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

	public function list(string $list){
		return $this->$list;
	}
}