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

	protected function __call($method, $arguments)
	{
		array_unshift($arguments, $method);
		$response = call_user_func_array([ $this, "call" ], $arguments);
		if ($response === false)
		{
			throw new \Exception("Router_exception :: Method {$method} not found");
		}
		return $response;
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
