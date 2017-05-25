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
		if(!empty($params['api'])){
			$this->waiting['api'] = $params['api'];
		}

		if(!empty($params['bundle'])){
			$this->waiting['bundle'] = $params['bundle'];
		}

		if(!empty($params['middleware'])){
			$this->waiting['middleware'][] = $params['middleware'];
		}

		$function();

		if(!empty($params['api'])){
			unset($this->waiting['api']);
		}

		if(!empty($params['bundle'])){
			unset($this->waiting['bundle']);
		}

		if(!empty($params['middleware'])){
			array_pop($this->waiting['middleware']);
		}

		return $this;
	}

	/**
	 * @param string $route
	 * @param mixed $path
	 * @param array $params
	 */
	protected function get(string $route, $path, array $params = [])
	{
		if(!empty($this->waiting['middleware']) || !empty($this->waiting['bundle']) || !empty($this->waiting['api'])){
			$middlewares = [];

			if(!empty($this->waiting['middleware'])){
                foreach($this->waiting['middleware'] as $m){
                    $middlewares[] = $m;
                }
            }

            if(is_string($path)){
            	$new_path = (!empty($this->waiting['bundle'])) ? $this->waiting['bundle'].':'.$path : $path;
            } else {
            	$new_path = $path;
            }

			$api = (!empty($this->waiting['api'])) ? $this->waiting['api'] : false;

			$this->get[ $route ] = [ 'path' => $new_path, 'params' => $params, 'middleware' => $middlewares, 'api' => $api ];
		} else {
			$this->get[ $route ] = [ 'path' => $path, 'params' => $params ];
		}

		return $this;
	}

	/**
	 * @param string $route
	 * @param string $path
	 * @param array $params
	 */
	protected function post(string $route, string $path, array $params = [])
	{
		if(!empty($this->waiting['middleware']) || !empty($this->waiting['bundle']) || !empty($this->waiting['api'])){
			$middlewares = [];

			if(!empty($this->waiting['middleware'])){
                foreach($this->waiting['middleware'] as $m){
                    $middlewares[] = $m;
                }
            }

            if(is_string($path)){
            	$new_path = (!empty($this->waiting['bundle'])) ? $this->waiting['bundle'].':'.$path : $path;
            } else {
            	$new_path = $path;
            }

			$api = (!empty($this->waiting['api'])) ? $this->waiting['api'] : false;

			$this->post[ $route ] = [ 'path' => $new_path, 'params' => $params, 'middleware' => $middlewares, 'api' => $api ];
		} else {
			$this->post[ $route ] = [ 'path' => $path, 'params' => $params ];
		}

		return $this;
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