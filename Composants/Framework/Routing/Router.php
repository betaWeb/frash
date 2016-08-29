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
         * @var int
         */
        private $nb_expl = 0;

        /**
         * @var string
         */
        private $lien = '';

        /**
         * @var string
         */
        private $route = '';

        /**
         * @var array
         */
        private $confarr = [];

        /**
         * @var array
         */
        private $routarr = [];

        /**
         * @var string
         */
        private $action = '';

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
                    $this->route = $rout_dev[ $path[0] ]['path'];
                    $this->action = $rout_dev[ $path[0] ]['action'];

                    return $this->devController();
                }
            }
            elseif(empty($path[0]) && !empty($this->confarr['racine']['path'])){
                $this->nb_expl = 1;
                $this->lien = '/';
                $this->route = $this->confarr['racine']['path'];

                $racine = 1;
            }
            elseif(count($path) == 2 && in_array($path[0], $this->routarr)){
                $this->nb_expl = 1;
                $this->lien = $path[0];
                $this->route = $this->routarr[ $this->lien ]['path'];
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

                        if(count($lien_array) > $this->nb_expl){
                            $this->nb_expl = count($lien_array);
                            $this->lien = implode('/', $lien_array);
                            $this->route = $precision['path'];
                        }
                    }
                }
            }

            if($this->nb_expl > 0 && $this->lien != '' && $this->route != ''){
                $list = explode('/', str_replace($this->lien.'/', '', implode('/', $path)));
                $get = [];

                if(isset($this->routarr[ $this->lien ]['get']) && $racine == 0){
                    $count_expl = count($list) - 1;
                    for($i = 0; $i <= $count_expl; $i++){
                        if(isset($this->routarr[ $this->lien ]['get'][ $i ])){
                            if($this->routarr[ $this->lien ]['get'][ $i ]['fix'] == 'yes' && empty($list[ $i ])){ return new GetChargementFail(); }

                            if($this->routarr[ $this->lien ]['get'][ $i ]['type'] != 'mixed'){
                                settype($list[ $i ], $this->routarr[ $this->lien ]['get'][ $i ]['type']);
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
                return $this->returnController($dic);
            }
            else{
                return new RouteChargementFail(implode('/', $path));
            }
        }

        /**
         * @param Dic $dic
         * @return object|ActionChargementFail|ControllerChargementFail
         */
        private function returnController(Dic $dic){
            list($bundle, $controller, $action) = explode(':', $this->route);
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

        /**
         * @return object
         */
        private function devController(){
            $routing = $this->route;
            $action = $this->action;

            if(file_exists($routing.'.php')){
                $rout = new $routing;
                return $rout->$action();
            }
        }
    }