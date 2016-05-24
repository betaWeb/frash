<?php
    namespace Composants\Framework\Routing;
    use Composants\Framework\Exception\ActionChargementFail;
    use Composants\Framework\Exception\ControllerChargementFail;
    use Composants\Framework\Exception\RouteChargementFail;
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
            $confarr = Yaml::parse(file_get_contents('Others/config/config.yml'));
            $routarr = Yaml::parse(file_get_contents('Others/config/'.$confarr['routing']['file']));

            if($confarr['log']['access'] == 'yes'){
                new CreateHTTPLog($url);
            }

            $nurl = explode('/', $url);

            if($confarr['env'] == 'prod'){
                if($confarr['traduction']['activate'] == 'yes' && in_array($nurl['0'], $confarr['traduction']['available'])){
                    $lang = $nurl['0'];
                    unset($nurl['0']);
                }
            }
            else{
                unset($nurl['0']);

                if($confarr['traduction']['activate'] == 'yes' && in_array($nurl['1'], $confarr['traduction']['available'])){
                    $lang = $nurl['1'];
                    unset($nurl['1']);
                }
            }

            $path = $nurl;

            array_unshift($path, 0);
            array_shift($path);

            if($path['0'] == '' && !empty($confarr['racine'])){
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
            else{
                $nb = 0;
                $lien = '';
                $route = '';

                $path2 = implode('/', $path);

                foreach($routarr as $key => $rout){
                    if(strstr($path2, $key)){
                        $exp = explode('/', $key);

                        if(count($exp) > $nb){
                            $nb = count($exp);
                            $lien = $key;
                            $route = $routarr[ $key ]['path'];
                        }
                    }
                }

                if($nb > 0 && $lien != '' && $route != ''){
                    $poss_get = str_replace($lien.'/', '', $path2);
                    $list = explode('/', $poss_get);

                    $get = [];

                    foreach($list as $v){
                        $get[] = urldecode(htmlentities($v));
                    }

                    list($bundle, $controller, $action) = explode(':', $route);
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
            }
        }
    }