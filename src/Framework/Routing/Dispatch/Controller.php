<?php
namespace Frash\Framework\Routing\Dispatch;
use Frash\Framework\DIC\Dic;
use Frash\Framework\Routing\Verification\Middleware;

/**
 * Class Controller
 * @package Frash\Framework\Routing\Dispatch
 */
class Controller
{
	/**
	 * @var Dic
	 */
	private $dic;

    /**
     * Controller constructor.
     * @param Dic $dic
     */
	public function __construct(Dic $dic)
	{
		$this->dic = $dic;
	}

	public function work($routing)
	{
		if(!empty($routing->array_get)){
            $this->dic->get = $routing->array_get;
        }

        list($bundle, $controller, $action) = explode(':', $routing->route);
        $path = 'Bundles\\'.$bundle.'\\Controllers\\'.$controller;

        if(method_exists($path, $action)){
            $this->dic->bundle = $bundle;

            try{
                $result = Middleware::define($this->dic, $routing->middleware);

                if($result === false){
                    return $this->dic->load('exception')->publish('Failed during test of middleware');
                }
            } catch(Exception $e){
                return $this->dic->load('exception')->publish($e->getMessage());
            }

            if($this->dic->conf['config']['analyzer'] == 'yes'){
                $this->dic->load('analyzer')->getRegistry()->setRoute(str_replace('/', '.', $routing->lien));
                $controller = $this->dic->load('controller');

                $controller->call($path)->$action();
                $controller->generationAnalyzer();
            } else {
                $this->dic->load('controller')->call($path)->$action();
            }
        } elseif(!file_exists('Bundles/'.$bundle.'/Controllers/'.ucfirst($controller).'.php')) {
            return $this->dic->load('exception')->publish('Controller '.$controller.' not found');
        } elseif(!method_exists($path, $action)) {
            return $this->dic->load('exception')->publish('Action '.$action.' not found');
        }
	}
}