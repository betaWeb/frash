<?php
namespace Frash\Framework\Dispatch;
use Frash\Framework\DIC\Dic;
use Frash\Framework\Dispatch\Router;
use Frash\Framework\Request\Server\Server;
use Frash\Framework\Routing\Prefix;
use Frash\Framework\Dispatch\Controller\Controller;

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
     * @param float $start_time
     */
	public function __construct(string $script_name, float $start_time)
    {
        $this->dic = new Dic();

        $this->dic->prefix = Prefix::define($script_name);
        $this->dic->uri = substr(Server::uri(), strlen($this->dic->prefix));

        $this->dic->preloading();
        $this->dic->load('microtime')->set('start', $start_time);
	}

	public function work(){
		$this->dic->load('microtime')->set('start', $this->start_time);

        $router = new Router($this->dic);
        $route = $router->define();

        $this->dic = $route->dic;

		if(count((array) $route) > 1){
			if($route->api === true){
				$this->api();
			} else {
				$this->controller($route);
			}
		}
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