<?php
namespace Frash\Framework\Routing;
use Frash\Framework\DIC\Dic;
use Frash\Framework\Exception\Exception;
use Frash\Framework\Log\CreateLog;
use Frash\Framework\Request\Server\Server;
use Frash\Framework\Routing\Verification\{ GetRoute, Middleware };

/**
 * Class Router
 * @package Frash\Framework\Routing
 */
class Router{
    /**
     * @var array
     */
    private $conf = [];

    /**
     * @var Dic
     */
    private $dic;

    /**
     * Router constructor.
     * @param Dic $dic
     */
	public function __construct(Dic $dic)
	{
		$this->dic = $dic;
        $this->conf = $this->dic->conf['config'];
	}

	/**
	 * @param string $url
	 * @return object
	 */
    public function route(string $url)
    {
        CreateLog::access($url, $this->conf['log']);

        $this->dic->uri = $url;
        $this->dic->cache_tpl = $this->conf['cache']['tpl'];
        $this->dic->env = $this->conf['env'];
        $this->dic->analyzer = $this->conf['analyzer'];

        $path = explode('/', $url);

        if(in_array($path[0], $this->conf['traduction']['available'])){
            $this->dic->lang = $path[0];
            unset($path[0]);
        } else {
            $this->dic->lang = $this->conf['traduction']['default'];
        }

        $this->dic->prefix_lang = $this->dic->prefix.$this->dic->lang;

        array_unshift($path, 0);
        array_shift($path);

        if($this->conf['analyzer'] == 'yes'){
            $this->dic->url_analyzer = (empty($path[0])) ? $this->conf['racine'].'/' : implode('/', $path);
            $this->dic->load('analyzer')->getRegistry()->setConfigPHP();
        }

        if(!empty($path[0]) && $path[0][0].$path[0][1] == '__'){
            if($path[0] == '__analyzer'){
                array_shift($path);
                $this->dic->load('analyzer')->display(implode('/', $path), rtrim(implode('.', $path), '.'));
            }
        } else {
        	$routarr = $this->dic->conf['routing']->list(strtolower(Server::requestMethod()));

            $api = false;
            $array_get = [];
            $lien = '';
            $middleware = [];
            $nb_expl = 0;
            $racine = false;
            $route = '';

            if(empty($path[0]) && !empty($this->conf['racine'])){
                $lien = '/';
                $route = $routarr[ $this->conf['racine'] ]['path'];
                $racine = true;

                if(!empty($routarr[ $this->conf['racine'] ]['api']) && $routarr[ $this->conf['racine'] ]['api'] == 'true'){
                    $api = true;
                }
            } elseif(count($path) == 2 && in_array($path[0], $routarr)) {
                $nb_expl = 1;
                $lien = $path[0];
                $route = $routarr[ $lien ]['path'];

                if(!empty($routarr[ $lien ]['api']) && $routarr[ $lien ]['api'] == 'true'){
                    $api = true;
                }
            } else {
                foreach($routarr as $key => $precision){
                    $expl_key = explode('/', $key);

                    if($path[0] == $expl_key[0] || $key[0] == ':'){
                        $lien_array = [];
                        $count_for = count($expl_key) - 1;

                        for($i = 0; $i <= $count_for; $i++){
                            if(!empty($path[ $i ]) && $path[ $i ] == $expl_key[ $i ]){
                                $lien_array[ 'part_'.$i ] = $expl_key[ $i ];
                            } elseif($expl_key[ $i ][0] == ':') {
                                if(substr($expl_key[ $i ], -1) == '?'){
                                    $sub_get = substr(str_replace('?', '', $expl_key[ $i ]), 1);

                                    if(!empty($path[ $i ]) && GetRoute::define($path[ $i ], $precision['params']['get'][ $sub_get ])) {
                                        $array_get[ $sub_get ] = $path[ $i ];
                                        $lien_array[ $sub_get ] = $expl_key[ $i ];
                                    } else {
                                        $array_get[ $sub_get ] = '';
                                        $lien_array[ $sub_get ] = $expl_key[ $i ];
                                    }
                                } else {
                                    $sub_get = substr($expl_key[ $i ], 1);

                                    if(!empty($path[ $i ]) && GetRoute::define($path[ $i ], $precision['params']['get'][ $sub_get ])){
                                        $array_get[ $sub_get ] = $path[ $i ];
                                        $lien_array[ $sub_get ] = $expl_key[ $i ];
                                    } else {
                                        return new Exception('Get : Url incorrecte.', $this->dic->conf['config']['log']);
                                    }
                                }
                            } else {
                                break;
                            }
                        }

                        if(count($lien_array) > $nb_expl){
                            $nb_expl = count($lien_array);
                            $lien = implode('/', $lien_array);
                            $route = $precision['path'];
                            $middleware = $precision['middleware'];
                            $api = (!empty($precision['api']) && $precision['api'] == 'true') ? true : false;
                        }
                    }
                }
            }

            if($api === true){
            } elseif(($nb_expl > 0 || $racine === true) && $lien != '' && $route != '' && $api === false) {
                if(!empty($array_get)){
                    $this->dic->get = $array_get;
                }

                list($bundle, $controller, $action) = explode(':', $route);
                $routing = 'Bundles\\'.$bundle.'\\Controllers\\'.$controller;

                if(method_exists($routing, $action)){
                    $this->dic->bundle = $bundle;

                    try{
                        $result = Middleware::define($this->dic, $middleware);

                        if($result === false){
                            return new Exception('Failed during test of middleware');
                        }
                    } catch(Exception $e){
                        CreateLog::error($e->getMessage(), $this->dic->conf['config']['log']);
                    }

                    if($this->conf['analyzer'] == 'yes'){
                        $this->dic->load('analyzer')->getRegistry()->setRoute(str_replace('/', '.', $lien));
                        $controller = $this->dic->load('controller');

                        $controller->call($routing)->$action();
                        $controller->generationAnalyzer();
                    } else {
                        $this->dic->load('controller')->call($routing)->$action();
                    }
                } elseif(!file_exists('Bundles/'.$bundle.'/Controllers/'.ucfirst($controller).'.php')) {
                    return new Exception('Controller '.$controller.' not found', $this->conf['log']);
                } elseif(!method_exists($routing, $action)) {
                    return new Exception('Action '.$action.' not found', $this->conf['log']);
                }
            } else {
                return new Exception('Route '.$route.' not found', $this->conf['log']);
            }
        }
    }
}