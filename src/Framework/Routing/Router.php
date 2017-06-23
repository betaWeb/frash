<?php
namespace Frash\Framework\Routing;
use Frash\Framework\DIC\Dic;

/**
 * Class Router
 * @package Frash\Framework\Routing
 */
class Router{
	/**
	 * @var array
	 */
	private $routes = [];

	/**
	 * @var array
	 */
	private $waiting = [];

	/**
	 * @var Dic
	 */
	private $dic;

    /**
     * Routing constructor.
     * @param Dic $dic
     */
	public function __construct(Dic $dic)
	{
		$this->dic = $dic;
	}

	/**
	 * @param array $params
	 * @param callable $function
	 */
	protected function group(array $params, callable $function)
	{
		if(!empty($params['bundle'])){
			$this->waiting['bundle'] = $params['bundle'];
		}

		if(!empty($params['middleware'])){
			$this->waiting['middleware'][] = $params['middleware'];
		}

		$function();

		if(!empty($params['bundle'])){
			unset($this->waiting['bundle']);
		}

		if(!empty($params['middleware'])){
			array_pop($this->waiting['middleware']);
		}

		return $this;
	}

	private function call(string $verb, string $route, $path, array $params = [])
	{
		$middlewares = [];

		if (!empty($this->waiting['middleware']) || !empty($this->waiting['bundle']))
		{
		    if (!empty($this->waiting['middleware']))
		    {
			foreach ($this->waiting['middleware'] as $m)
			{
			    $middlewares[] = $m;
			}
		    }

		    $new_path = is_string($path) && !empty($this->waiting['bundle']) ? $this->waiting['bundle'].':'.$path : $path;
		}

		if (!isset($this->routes[ $verb ]))
		{
		    $this->routes[ $verb ] = [];
		}

		$this->routes[ $verb ][ $route ] = [ 'path' => $new_path, 'params' => $params, 'middleware' => $middlewares ];

		return $this;
	}

	protected function get(string $route, $path, array $params = [])
	{
		return $this->call('get', string $route, $path, array $params = []);
	}

	protected function post(string $route, $path, array $params = [])
	{
		return $this->call('post', string $route, $path, array $params = []);
	}

	protected function put(string $route, $path, array $params = [])
	{
		return $this->call('put', string $route, $path, array $params = []);
	}

	protected function delete(string $route, $path, array $params = [])
	{
		return $this->call('delete', string $route, $path, array $params = []);
	}

	protected function patch(string $route, $path, array $params = [])
	{
		return $this->call('patch', string $route, $path, array $params = []);
	}

	/**
	 * @param string $list
	 * @return array
	 */
	public function list(string $list): array
	{
		return $this->$list;
	}
}
