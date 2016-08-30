<?php
    namespace Composants\Framework\Routing;
    use Composants\Framework\CreateLog\CreateHTTPLog;
    use Composants\Framework\DIC\Dic;
    use Composants\Framework\Exception\ActionChargementFail;
    use Composants\Framework\Exception\ControllerChargementFail;
    use Composants\Framework\Exception\GetChargementFail;
    use Composants\Framework\Exception\RouteChargementFail;
    use Composants\Framework\Globals\Get;
    use Composants\Yaml\Yaml;

    /**
     * Traite l'URL et détermine le bundle, le controller et l'action
     *
     * Class Router
     * @package Composants\Framework\Routing
     */
    class Router{
        /**
         * @var array
         */
        private $confarr = [];

        /**
         * @var array
         */
        private $routarr = [];

        /**
         * Router constructor.
         */
        public function __construct(){
            $this->confarr = Yaml::parse(file_get_contents('Composants/Configuration/config.yml'));
            $this->routarr = Yaml::parse(file_get_contents('Composants/Configuration/'.$this->confarr['routing']['file']));
        }

        /**
         * @param string $url
         * @param Dic $dic
         * @return ActionChargementFail|ControllerChargementFail|RouteChargementFail|GetChargementFail
         */
        public function routing($url, Dic $dic){
            new CreateHTTPLog($url);

            $path = explode('/', $url);
            $route = '';
            $nb_expl = 0;
            $lien = '';

            if('/'.$path[0] == $this->confarr['prefix'] && !empty($path[0])){
                if(in_array($path[1], $this->confarr['traduction']['available'])){
                    unset($path[0], $path[1]);
                }
                elseif(!in_array($path[1], $this->confarr['traduction']['available'])){
                    $slice = array_slice($path, 1);
                    $path = $slice;
                }
            }
            elseif(in_array($path[0], $this->confarr['traduction']['available'])){
                unset($path[0]);
            }

            array_unshift($path, 0);
            array_shift($path);

            $racine = 0;

            if(!empty($path[0]) && $path[0][0].$path[0][1] == '__'){
                $rout_dev = Yaml::parse(file_get_contents('Composants/Configuration/routing_dev.yml'));

                if(isset($rout_dev[ $path[0] ]) && $this->confarr['env'] == 'local'){
                    $route = $rout_dev[ $path[0] ]['path'];
                    $action = $rout_dev[ $path[0] ]['action'];

                    if(file_exists($route.'.php')){
                        $rout = new $route;
                        return $rout->$action();
                    }
                }
            }
            elseif(empty($path[0]) && !empty($this->confarr['racine']['path'])){
                $nb_expl = 1;
                $lien = '/';
                $route = $this->confarr['racine']['path'];

                $racine = 1;
            }
            elseif(count($path) == 2 && in_array($path[0], $this->routarr)){
                $nb_expl = 1;
                $lien = $path[0];
                $route = $this->routarr[ $lien ]['path'];
            }
            else{
                foreach($this->routarr as $key => $precision){
                    if(strstr($url, $key)){
                        $expl_key = explode('/', $key);
                        $lien_array = [];
                        $count_for = count($expl_key) - 1;

                        for($i = 0; $i <= $count_for; $i++){
                            if(!empty($path[ $i ]) && $path[ $i ] == $expl_key[ $i ]){
                                $lien_array[] = $expl_key[ $i ];
                            }
                        }

                        if(count($lien_array) > $nb_expl){
                            $nb_expl = count($lien_array);
                            $lien = implode('/', $lien_array);
                            $route = $precision['path'];
                        }
                    }
                }
            }

            if($nb_expl > 0 && $lien != '' && $route != ''){
                $list = explode('/', str_replace($lien.'/', '', implode('/', $path)));
                $get = [];

                if(isset($this->routarr[ $lien ]['get']) && $racine == 0){
                    $count_expl = count($list) - 1;
                    for($i = 0; $i <= $count_expl; $i++){
                        if(isset($this->routarr[ $lien ]['get'][ $i ])){
                            if($this->routarr[ $lien ]['get'][ $i ]['fix'] == 'yes' && empty($list[ $i ])){ return new GetChargementFail(); }

                            if($this->routarr[ $lien ]['get'][ $i ]['type'] != 'mixed'){
                                settype($list[ $i ], $this->routarr[ $lien ]['get'][ $i ]['type']);
                            }

                            $get[] = urldecode(htmlentities($list[ $i ]));
                        }
                    }
                }
                elseif(isset($this->confarr['racine']['get']) && $racine == 1){
                    $count_expl = count($list) - 1;
                    for($i = 0; $i <= $count_expl; $i++){
                        if(isset($this->confarr['racine']['get'][ $i ])){
                            if($this->confarr['racine']['get'][ $i ]['fix'] == 'yes' && empty($list[ $i ])){ return new GetChargementFail(); }

                            if($this->confarr['racine']['get'][ $i ]['type'] != 'mixed'){
                                settype($list[ $i ], $this->confarr['racine']['get'][ $i ]['type']);
                            }

                            $get[] = urldecode(htmlentities($list[ $i ]));
                        }
                    }
                }

                Get::set($get);

                list($bundle, $controller, $action) = explode(':', $route);
                $routing = 'Bundles\\'.$bundle.'\\Controllers\\'.$controller;

                if(method_exists($routing, $action)){
                    $rout = new $routing($dic);
                    return $rout->$action($dic);
                }
                elseif(!file_exists('Bundles/'.$bundle.'/Controllers/'.ucfirst($controller).'.php')){
                    return new ControllerChargementFail($controller);
                }
                elseif(!method_exists($routing, $action)){
                    return new ActionChargementFail($action);
                }
            }
            else{
                return new RouteChargementFail(implode('/', $path));
            }
        }
    }