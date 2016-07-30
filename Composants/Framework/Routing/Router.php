<?php
    namespace Composants\Framework\Routing;
    use Composants\Framework\CreateLog\CreateHTTPLog;
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
        private static $nb_expl = 0;

        /**
         * @var string
         */
        private static $lien = '';

        /**
         * @var string
         */
        private static $route = '';

        /**
         * @var array
         */
        private static $path = [];

        /**
         * @var array
         */
        private static $confarr = [];

        /**
         * @var array
         */
        private static $routarr = [];

        /**
         * @var string
         */
        private static $url = '';

        /**
         * @var string
         */
        private static $static = '';

        /**
         * @var string
         */
        private static $action = '';

        /**
         * Router constructor.
         * @param string $url
         */
        public function __construct($url){
            new CreateHTTPLog($url);

            self::$confarr = Yaml::parse(file_get_contents('Others/config/config.yml'));
            self::$routarr = Yaml::parse(file_get_contents('Others/config/'.self::$confarr['routing']['file']));

            self::$url = $url;
            self::$path = explode('/', $url);
        }

        public static function routing(){
            if('/'.self::$path[0] == self::$confarr['prefix'] && !empty(self::$path['0'])){
                if(in_array(self::$path[1], self::$confarr['traduction']['available'])){
                    unset(self::$path[0], self::$path[1]);
                }
                elseif(!in_array(self::$path[1], self::$confarr['traduction']['available'])){
                    $slice = array_slice(self::$path, 1);
                    self::$path = $slice;
                }
            }
            elseif(in_array(self::$path[0], self::$confarr['traduction']['available'])){
                unset(self::$path[0]);
            }

            array_unshift(self::$path, 0);
            array_shift(self::$path);

            $racine = 0;

            if(self::$path[0][0].self::$path[0][1] == '__'){
                $rout_dev = Yaml::parse(file_get_contents('Others/config/config.yml'));

                if(isset($rout_dev[ self::$path[0] ]) && self::$confarr['env'] == 'local'){
                    self::$route = $rout_dev[ self::$path[0] ]['path'];
                    self::$action = $rout_dev[ self::$path[0] ]['action'];

                    return self::devController();
                }
            }

            if(empty(self::$path[0]) && !empty(self::$confarr['racine']['path'])){
                self::$nb_expl = 1;
                self::$lien = '/';
                self::$route = self::$confarr['racine']['path'];

                $racine = 1;
            }
            elseif(count(self::$path) == 2 && in_array(self::$path[0], self::$routarr)){
                self::$nb_expl = 1;
                self::$lien = self::$path[0];
                self::$route = self::$routarr[ self::$lien ]['path'];
            }
            else{
                foreach(self::$routarr as $key => $precision){
                    if(strstr(self::$url, $key)){
                        $expl_key = explode('/', $key);
                        $lien_array = [];
                        $count_for = count($expl_key) - 1;

                        for($i = 0; $i <= $count_for; $i++){
                            if(!empty(self::$path[ $i ]) && self::$path[ $i ] == $expl_key[ $i ]){
                                $lien_array[] = $expl_key[ $i ];
                            }
                        }

                        if(count($lien_array) > self::$nb_expl){
                            self::$nb_expl = count($lien_array);
                            self::$lien = implode('/', $lien_array);
                            self::$route = $precision['path'];
                        }
                    }
                }
            }

            if(self::$nb_expl > 0 && self::$lien != '' && self::$route != ''){
                $list = explode('/', str_replace(self::$lien.'/', '', implode('/', self::$path)));
                $get = [];

                if(!isset(self::$routarr[ self::$lien ]['static']) || self::$routarr[ self::$lien ]['static'] == 'no'){
                    self::$static = 'no';
                }
                elseif(isset(self::$routarr[ self::$lien ]['static']) && self::$routarr[ self::$lien ]['static'] == 'yes'){
                    self::$static = 'yes';
                }

                if(isset(self::$routarr[ self::$lien ]['get']) && $racine == 0){
                    $count_expl = count($list) - 1;
                    for($i = 0; $i <= $count_expl; $i++){
                        if(isset(self::$routarr[ self::$lien ]['get'][ $i ])){
                            if(self::$routarr[ self::$lien ]['get'][ $i ]['fix'] == 'yes' && empty($list[ $i ])){ return new GetChargementFail(); }

                            if(self::$routarr[ self::$lien ]['get'][ $i ]['type'] != 'mixed'){
                                settype($list[ $i ], self::$routarr[ self::$lien ]['get'][ $i ]['type']);
                            }

                            $get[] = urldecode(htmlentities($list[ $i ]));
                        }
                    }
                }
                elseif(isset(self::$confarr['racine']['get']) && $racine == 1){
                    $count_expl = count($list) - 1;
                    for($i = 0; $i <= $count_expl; $i++){
                        if(isset(self::$confarr['racine']['get'][ $i ])){
                            if(self::$confarr['racine']['get'][ $i ]['fix'] == 'yes' && empty($list[ $i ])){ return new GetChargementFail(); }

                            if(self::$confarr['racine']['get'][ $i ]['type'] != 'mixed'){
                                settype($list[ $i ], self::$confarr['racine']['get'][ $i ]['type']);
                            }

                            $get[] = urldecode(htmlentities($list[ $i ]));
                        }
                    }
                }

                Get::set($get);
                return self::returnController();
            }
            else{
                return new RouteChargementFail(implode('/', self::$path));
            }
        }

        /**
         * @return object|ActionChargementFail|ControllerChargementFail
         */
        private static function returnController(){
            list($bundle, $controller, $action) = explode(':', self::$route);
            $routing = 'Bundles\\'.$bundle.'\\Controllers\\'.$controller;

            if(method_exists($routing, $action)){
                switch(self::$static){
                    case 'no':
                        $rout = new $routing;
                        return $rout->$action();
                    case 'yes':
                        new $routing;
                        return $routing::$action();
                }
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
        private static function devController(){
            $routing = self::$route;
            $action = self::$action;

            if(file_exists($routing.'.php')){
                $rout = new $routing;
                return $rout->$action();
            }
        }
    }