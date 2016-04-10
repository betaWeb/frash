<?php
    namespace Composants\Framework\Routing;
    use Composants\Framework\Exception\ActionChargementFail;
    use Composants\Framework\Exception\ControllerChargementFail;
    use Composants\Framework\Exception\PathNotFound;
    use Composants\Yaml\Yaml;
    use Composants\Framework\CreateLog\CreateHTTPLog;

    /**
     * Traite l'URL et détermine le bundle, le controller et l'action
     *
     * Class Router
     * @package Composants\Framework\Routing
     */
    class Router{
        /**
         * Router constructor.
         * @param $url
         */
        public function __construct($url){
            $routarr = Yaml::parse(file_get_contents('Others/config/routing.yml'));
            $confarr = Yaml::parse(file_get_contents('Others/config/config.yml'));

            if($confarr['log']['access'] == 'yes'){
                new CreateHTTPLog($url);
            }

            $nurl = explode('/', $url);

            if($confarr['env'] == 'local'){
                $this->dir = $nurl[0];
                $path = $nurl[1];
            }
            else{
                $path = $nurl[0];
            }

            if($path == '__debug' && $confarr['env'] == 'local'){

            }
            elseif($path == '__clientsql'){

            }
            elseif($path == ''){
                list($bundle, $controller, $action) = explode(':', $confarr['racine']);
                $routing = 'Bundles\\'.$bundle.'\\Controllers\\'.$controller;

                if(file_exists('Bundles/'.$bundle.'/Controllers/'.ucfirst($controller).'.php') && method_exists($routing, $action)){
                    $rout = new $routing;
                    return $rout->$action();
                }
                elseif(!file_exists('Bundles/'.$bundle.'/Controllers/'.ucfirst($controller).'.php')){
                    return new ControllerChargementFail($controller);
                }
                elseif(!method_exists($routing, $action)){
                    return new ActionChargementFail($action);
                }
            }
            elseif(isset($routarr[ $path ])){
                unset($nurl[0]);

                if($confarr['env'] == 'local'){
                    unset($nurl[1]);
                }

                $get = [];
                foreach($nurl as $v){
                    $get[] = urldecode(htmlentities($v));
                }

                $expl = explode(':', $routarr[ $path ]['path']);

                $bundle = $expl[0];
                $controller = $expl[1];
                $action = $expl[2];
                $routing = 'Bundles\\'.$bundle.'\\Controllers\\'.$controller;

                if(file_exists('Bundles/'.$bundle.'/Controllers/'.ucfirst($controller).'.php') && method_exists($routing, $action)){
                    $rout = new $routing;
                    return $rout->$action($get);
                }
                elseif(!file_exists('Bundles/'.$bundle.'/Controllers/'.ucfirst($controller).'.php')){
                    return new ControllerChargementFail($controller);
                }
                elseif(!method_exists($routing, $action)){
                    return new ActionChargementFail($action);
                }
            }
            else{
                return new PathNotFound($path);
            }
        }
    }