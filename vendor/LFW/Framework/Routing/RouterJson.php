<?php
namespace LFW\Framework\Routing;
use LFW\Framework\DIC\Dic;
use LFW\Framework\Exception\Exception;
use LFW\Framework\FileSystem\Json;
use LFW\Framework\Globals\Server\Server;
use LFW\Framework\Log\CreateLog;
use LFW\Framework\Routing\Gets\GetRoute;

/**
 * Class RouterJson
 * @package LFW\Framework\Routing
 */
class RouterJson
{
    /**
     * @var Dic
     */
    private $dic;

    /**
     * RouterJson constructor.
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
    public function routing(string $url, array $conf)
    {
        CreateLog::access($url);

        $path = explode('/', $url);

        $this->dic->set('uri', $url);
        $this->dic->set('cache_tpl', $conf['cache']['tpl']);
        $this->dic->set('env', $conf['env']);
        $this->dic->set('analyzer', $conf['analyzer']);

        if(in_array($path[0], $conf['traduction']['available'])){
            $this->dic->set('lang', $path[0]);
            unset($path[0]);
        } else {
            $this->dic->set('lang', $conf['traduction']['default']);
        }

        $this->dic->set('prefix_lang', $this->dic->get('prefix').$this->dic->get('lang'));

        array_unshift($path, 0);
        array_shift($path);

        if($conf['analyzer'] == 'yes'){
            $this->dic->set('url_analyzer', implode('/', $path));
            $this->dic->load('analyzer')->getRegistry()->setConfigPHP();
        }

        if(!empty($path[0]) && $path[0][0].$path[0][1] == '__'){
            if($path[0] == '__analyzer'){
                array_shift($path);
                $this->dic->load('analyzer')->display(implode('/', $path), rtrim(implode('.', $path), '.'));
            }
        } else {
            $racine = false;
            $routarr = Json::importRouting();
            $lien = '';
            $nb_expl = 0;
            $route = '';
            $api = false;
            $array_get = [];

            if(empty($path[0]) && !empty($conf['racine']['path'])){
                $lien = '/';
                $route = $conf['racine']['path'];
                $racine = true;

                if(!empty($conf['racine']['api']) && $conf['racine']['api'] == 'true'){
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
                                $sub_get = substr($expl_key[ $i ], 1);

                                if(!empty($path[ $i ]) && GetRoute::define($path[ $i ], $precision['get'][ $sub_get ]) === true){
                                    $array_get[ $sub_get ] = $path[ $i ];
                                    $lien_array[ $sub_get ] = $expl_key[ $i ];
                                } else {
                                    break;
                                }
                            } else {
                                break;
                            }
                        }

                        if(count($lien_array) > $nb_expl){
                            $nb_expl = count($lien_array);
                            $lien = implode('/', $lien_array);
                            $route = $precision['path'];
                            $api = (!empty($precision['api']) && $precision['api'] == 'true') ? true : false;
                        }
                    }
                }
            }

            if($api === true){
            } elseif(($nb_expl > 0 || $racine === true) && $lien != '' && $route != '' && $api === false) {
                if(!empty($routarr[ $lien ]['type']) && $routarr[ $lien ]['type'] != Server::getRequestMethod()){
                    return new Exception('Request Method not correct');
                }

                if(!empty($array_get)){
                    $this->dic->set('get', $array_get);
                }

                list($bundle, $controller, $action) = explode(':', $route);
                $routing = 'Bundles\\'.$bundle.'\\Controllers\\'.$controller;

                if(method_exists($routing, $action)){
                    $this->dic->set('bundle', $bundle);

                    if($conf['analyzer'] == 'yes'){
                        $this->dic->load('analyzer')->getRegistry()->setRoute(str_replace('/', '.', $lien));

                        $controller = $this->dic->load('controller');
                        $controller->call($routing)->$action($this->dic);
                        $controller->generationAnalyzer();
                    } else {
                        $this->dic->load('controller')->call($routing)->$action($this->dic);
                    }
                } elseif(!file_exists('Bundles/'.$bundle.'/Controllers/'.ucfirst($controller).'.php')) {
                    return new Exception('Controller '.$controller.' not found');
                } elseif(!method_exists($routing, $action)) {
                    return new Exception('Action '.$action.' not found');
                }
            } else {
                $route = (empty($path)) ? '' : implode('/', $path);
                return new Exception('Route '.$route.' not found');
            }
        }
    }
}