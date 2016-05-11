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
                $good = 0;
                $get = [];

                foreach($routarr as $key => $rout){
                    $nv = explode('/', $key);
                    $count = count(explode('/', $key));
                    $soust = $count - 1;

                    if($path['0'] == $nv['0'] && count($nv) == 1){
                        $good = 1;

                        list($bundle, $controller, $action) = explode(':', $routarr[ $key ]['path']);
                        $routing = 'Bundles\\'.$bundle.'\\Controllers\\'.$controller;

                        if(count($path) > $count){
                            $list = explode('/', str_replace($key.'/', '', implode('/', $path)));

                            foreach($list as $v){
                                $get[] = urldecode(htmlentities($v));
                            }
                        }

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
                    elseif($path['0'] == $nv['0'] && count($nv) > 1){
                        for($i = 1; $i < $count; $i++){
                            if($nv[$i] != $path[$i]){
                                break;
                            }
                            elseif($nv[$i] == $path[$i] && $i == $soust){
                                $good = 1;

                                list($bundle, $controller, $action) = explode(':', $routarr[ $key ]['path']);
                                $routing = 'Bundles\\'.$bundle.'\\Controllers\\'.$controller;

                                if(count($path) > $count){
                                    $list = explode('/', str_replace($key.'/', '', implode('/', $path)));

                                    foreach($list as $v){
                                        $get[] = urldecode(htmlentities($v));
                                    }
                                }

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

                    if($good == 1){
                        break;
                    }
                }

                if($good == 0){
                    return new RouteChargementFail(implode('/', $path));
                }
            }
        }
    }