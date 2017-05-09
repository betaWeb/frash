<?php
namespace Frash\Framework\Dispatch\Controller;
use Frash\Framework\DIC\Dic;
use Frash\Framework\Routing\Verification\Middleware;

/**
 * Class Controller
 * @package Frash\Framework\Dispatch\Controller
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

    /**
     * @param object $routing
     * @return mixed
     */
	public function work($routing)
	{
		if(!empty($routing->array_get)){
            $this->dic->get = $routing->array_get;
        }

        list($bundle, $controller, $action) = explode(':', $routing->route);
        $path = 'Bundles\\'.$bundle.'\\Controllers\\'.$controller;

        if(method_exists($path, $action)){
            $this->dic->bundle = $bundle;

            if(!empty($routing->middleware)){
                try{
                    $result = Middleware::define($this->dic, $routing->middleware);

                    if($result === false){
                        return $this->dic->load('exception')->publish('Failed during test of middleware');
                    }
                } catch(\Exception $e){
                    return $this->dic->load('exception')->publish($e->getMessage());
                }
            }

            if($this->dic->config['inspecter']['activ'] == 'yes'){
                $this->dic->load('inspecter')->registry()->setRoute(str_replace('/', '.', $routing->lien));
                $this->callAction($bundle, $controller, $action);
            } else {
                $this->callAction($bundle, $controller, $action);
            }
        } elseif(!file_exists('Bundles/'.$bundle.'/Controllers/'.$controller.'.php')) {
            return $this->dic->load('exception')->publish('Controller '.$controller.' not found');
        } elseif(!method_exists($path, $action)) {
            return $this->dic->load('exception')->publish('Action '.$action.' not found');
        }
	}

    /**
     * @param string $bundle
     * @param string $controller
     * @param string $action
     */
    private function callAction(string $bundle, string $controller, string $action)
    {
        $path = 'Bundles\\'.$bundle.'\Controllers\\'.$controller;
        $class = new \ReflectionClass($path);

        if($class->isInstantiable()){
            $method = new \ReflectionMethod($path, $action);
            $params_method = $method->getParameters();
            $params = [];

            foreach($params_method as $param){
                $type = $param->getType();

                if($type == 'Frash\Framework\DIC\Dic'){
                    $params[] = $this->dic;
                } else {
                    $params[] = $this->dic->loadSpecial($type, $param->name);
                }
            }

            $method->invokeArgs(new $path($this->dic), $params);
        }
    }
}