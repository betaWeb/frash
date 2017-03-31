<?php
namespace Frash\Framework\Dispatch;
use Frash\Framework\DIC\Dic;
use Frash\Framework\Dispatch\Router;
use Frash\Framework\Request\Server\Server;
use Frash\Framework\Routing\Prefix;
use Frash\Framework\Routing\Dispatch\Controller;

/**
 * Class Dispatcher
 * @package Frash\Framework\Dispatch
 */
class Dispatcher{
	/**
	 * @var integer
	 */
	private $start_time = 0;

	/**
	 * @var Dic
	 */
	private $dic;

    /**
     * Dispatcher constructor.
     * @param string $script_name
     * @param int $start_time
     */
	public function __construct(string $script_name, int $start_time){
		$this->start_time = $start_time;

		$this->dic = new Dic();
		$this->dic->prefix = Prefix::define($script_name);
	}

	public function work(){
		$this->dic->load('microtime')->set('start', $this->start_time);
		$route = $this->routing();

		if(count($route) > 1){
			if($route->api === true){
				$this->api();
			} else {
				$this->controller($route);
			}
		}
	}

	/**
	 * @return object
	 */
	private function routing(){
		$router = new Router($this->dic);
		$route = $router->route(substr(Server::requestUri(), strlen($this->dic->prefix)));

		$this->dic = $route->dic;
		return $route;
	}

	/**
	 * @param object $routing
	 * @return object
	 */
	private function controller($routing){
		if(($routing->nb_expl > 0 || $routing->racine === true) && $routing->lien != '' && $routing->route != ''){
            $controller = new Controller($this->dic);
            $controller->work($routing);
        }
	}
}