<?php
    namespace Composants\Framework\Routing;
    use Composants\Framework\Exception\ActionChargementFail;
    use Composants\Framework\Exception\ControllerChargementFail;
    use Composants\Framework\Exception\RouteChargementFail;
    use Composants\Framework\CreateLog\CreateHTTPLog;
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
        private $get = [];

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
         * @var string
         */
        private $path2 = '';

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

            $path = explode('/', $url);

            if($confarr['env'] == 'prod'){
                if($confarr['traduction']['activate'] == 'yes' && in_array($path['0'], $confarr['traduction']['available'])){
                    unset($path['0']);
                }
            }
            else{
                unset($path['0']);

                if($confarr['traduction']['activate'] == 'yes' && in_array($path['1'], $confarr['traduction']['available'])){
                    unset($path['1']);
                }
            }

            array_unshift($path, 0);
            array_shift($path);

            $this->path2 = implode('/', $path);

            if($path['0'] == '' && !empty($confarr['racine'])){
                $this->nb_expl = 1;
                $this->lien = '/';
                $this->route = $confarr['racine'];
            }
            elseif(count($path) == 2){
                $this->lien = $path['0'];
                $this->route = $routarr[ $this->lien ]['path'];
                $this->nb_expl = 1;
            }
            else{
                foreach($routarr as $key => $rout){
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
                        $this->route = $routarr[ $this->lien ]['path'];
                    }
                }
            }

            if($this->nb_expl > 0 && $this->lien != '' && $this->route != ''){
                if($this->lien != '/'){
                    $list = explode('/', str_replace($this->lien.'/', '', $this->path2));

                    foreach($list as $v){
                        $this->get[] = urldecode(htmlentities($v));
                    }
                }

                $this->returnController();
            }
            else{
                return new RouteChargementFail($this->path2);
            }
        }

        /**
         * @return ActionChargementFail|ControllerChargementFail
         */
        private function returnController(){
            list($bundle, $controller, $action) = explode(':', $this->route);
            $routing = 'Bundles\\'.$bundle.'\\Controllers\\'.$controller;

            if(file_exists('Bundles/'.$bundle.'/Controllers/'.ucfirst($controller).'.php') && method_exists($routing, $action)){
                $rout = new $routing;
                return $rout->$action($this->get);
            }
            elseif(!file_exists('Bundles/'.$bundle.'/Controllers/'.ucfirst($controller).'.php')){
                return new ControllerChargementFail($controller);
            }
            elseif(!method_exists($routing, $action)){
                return new ActionChargementFail($action);
            }
        }
    }