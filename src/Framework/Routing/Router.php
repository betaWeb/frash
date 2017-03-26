<?php
namespace Frash\Framework\Routing;
use Frash\Framework\DIC\Dic;
use Frash\Framework\Exception\Exception;
use Frash\Framework\Log\CreateLog;
use Frash\Framework\Request\Server\Server;
use Frash\Framework\Routing\HomePage;
use Frash\Framework\Routing\Verification\{ GetRoute, Middleware };

/**
 * Class Router
 * @package Frash\Framework\Routing
 */
class Router{
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
	}

	/**
	 * @param string $url
	 * @return object
	 */
    public function route(string $url)
    {
        $conf = $this->dic->conf['config'];
        CreateLog::access($url, $conf['log']);

        $this->dic->uri = $url;
        $this->dic->cache_tpl = $conf['cache']['tpl'];
        $this->dic->env = $conf['env'];
        $this->dic->analyzer = $conf['analyzer'];

        $path = explode('/', $url);

        if(in_array($path[0], $conf['traduction']['available'])){
            $this->dic->lang = $path[0];
            unset($path[0]);
        } else {
            $this->dic->lang = $conf['traduction']['default'];
        }

        $this->dic->prefix_lang = $this->dic->prefix.$this->dic->lang;

        array_unshift($path, 0);
        array_shift($path);

        if($conf['analyzer'] == 'yes'){
            $this->dic->url_analyzer = (empty($path[0])) ? $conf['racine'].'/' : implode('/', $path);
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

            if(empty($path[0]) && empty($conf['racine'])){
                $hp = new HomePage($this->dic);
                return $hp->show();
            } elseif(empty($path[0]) && !empty($conf['racine'])) {
                $lien = '/';
                $route = $routarr[ $conf['racine'] ]['path'];
                $racine = true;

                if(!empty($routarr[ $conf['racine'] ]['api']) && $routarr[ $conf['racine'] ]['api'] == 'true'){
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
                                        return $this->dic->load('exception')->publish('Get : Url incorrecte.');
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
                            return $this->dic->load('exception')->publish('Failed during test of middleware');
                        }
                    } catch(Exception $e){
                        return $this->dic->load('exception')->publish($e->getMessage());
                    }

                    if($conf['analyzer'] == 'yes'){
                        $this->dic->load('analyzer')->getRegistry()->setRoute(str_replace('/', '.', $lien));
                        $controller = $this->dic->load('controller');

                        $controller->call($routing)->$action();
                        $controller->generationAnalyzer();
                    } else {
                        $this->dic->load('controller')->call($routing)->$action();
                    }
                } elseif(!file_exists('Bundles/'.$bundle.'/Controllers/'.ucfirst($controller).'.php')) {
                    return $this->dic->load('exception')->publish('Controller '.$controller.' not found');
                } elseif(!method_exists($routing, $action)) {
                    return $this->dic->load('exception')->publish('Action '.$action.' not found');
                }
            } else {
                return $this->dic->load('exception')->publish('URL '.$url.' not found');
            }
        }
    }
}