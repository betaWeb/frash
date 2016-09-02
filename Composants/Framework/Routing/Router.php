<?php
    namespace Composants\Framework\Routing;
    use Composants\Framework\CreateLog\CreateHTTPLog;
    use Composants\Framework\DIC\Dic;
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
         * @param string $url
         * @param Dic $dic
         * @return object
         */
        public function routing($url = '', Dic $dic){
            $conf = Yaml::parse(file_get_contents('Composants/Configuration/config.yml'));
            new CreateHTTPLog($url);

            $path = explode('/', $url);
            $route = '';
            $nb_expl = 0;
            $lien = '';

            if('/'.$path[0] == $conf['prefix'] && !empty($path[0])){
                if(in_array($path[1], $conf['traduction']['available'])){
                    unset($path[0], $path[1]);
                }
                elseif(!in_array($path[1], $conf['traduction']['available'])){
                    $slice = array_slice($path, 1);
                    $path = $slice;
                }
            }
            elseif(in_array($path[0], $conf['traduction']['available'])){
                unset($path[0]);
            }

            array_unshift($path, 0);
            array_shift($path);

            $racine = 0;
            $routarr = Yaml::parse(file_get_contents('Composants/Configuration/'.$conf['routing']['file']));

            if(!empty($path[0]) && $path[0][0].$path[0][1] == '__'){
                $rout_dev = Yaml::parse(file_get_contents('Composants/Configuration/routing_dev.yml'));

                if(isset($rout_dev[ $path[0] ]) && $conf['env'] == 'local'){
                    $route = $rout_dev[ $path[0] ]['path'];
                    $action = $rout_dev[ $path[0] ]['action'];

                    if(file_exists($route.'.php')){
                        $rout = new $route;
                        return $rout->$action();
                    }
                }
            }
            elseif(empty($path[0]) && !empty($conf['racine']['path'])){
                $nb_expl = 1;
                $lien = '/';
                $route = $conf['racine']['path'];

                $racine = 1;
            }
            elseif(count($path) == 2 && in_array($path[0], $routarr)){
                $nb_expl = 1;
                $lien = $path[0];
                $route = $routarr[ $lien ]['path'];
            }
            else{
                foreach($routarr as $key => $precision){
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

            $fail = $dic->load('fail');

            if($nb_expl > 0 && $lien != '' && $route != ''){
                $list = explode('/', str_replace($lien.'/', '', implode('/', $path)));
                $get = [];
                $types = [ 'integer', 'double', 'string' ];

                if(isset($routarr[ $lien ]['get']) && $racine == 0){
                    $count_expl = count($list) - 1;
                    for($i = 0; $i <= $count_expl; $i++){
                        if(isset($routarr[ $lien ]['get'][ $i ])){
                            if($routarr[ $lien ]['get'][ $i ]['fix'] == 'yes' && empty($list[ $i ])){ return $fail->get(); }
                            if(!in_array($routarr[ $lien ]['get'][ $i ]['type'], $types)){ return $fail->get(); }

                            if($routarr[ $lien ]['get'][ $i ]['type'] == 'integer'){
                                if(!ctype_digit($list[ $i ])){ return $fail->get(); }
                            }

                            $get[] = urldecode(htmlentities($list[ $i ]));
                        }
                    }
                }
                elseif(isset($conf['racine']['get']) && $racine == 1){
                    $count_expl = count($list) - 1;
                    for($i = 0; $i <= $count_expl; $i++){
                        if(isset($conf['racine']['get'][ $i ])){
                            if($conf['racine']['get'][ $i ]['fix'] == 'yes' && empty($list[ $i ])){ return $fail->get(); }
                            if(!in_array($conf['racine']['get'][ $i ]['type'], $types)){ return $fail->get(); }

                            if($conf['racine']['get'][ $i ]['fix'] == 'yes' || ($conf['racine']['get'][ $i ]['fix'] == 'no' && !empty($list[ $i ]))){
                                if($conf['racine']['get'][ $i ]['type'] == 'integer' && !ctype_digit($list[ $i ])){ return $fail->get(); }
                                if($conf['racine']['get'][ $i ]['type'] == 'double' && !preg_match('/[^0-9(.{1})]/', $list[ $i ])){ return $fail->get(); }
                            }

                            $get[] = urldecode(htmlentities($list[ $i ]));
                        }
                    }
                }

                Get::set($get);

                list($bundle, $controller, $action) = explode(':', $route);
                $routing = 'Bundles\\'.$bundle.'\\Controllers\\'.$controller;

                if(method_exists($routing, $action)){
                    return $dic->load('controller')->getController($dic, $routing)->$action($dic);
                }
                elseif(!file_exists('Bundles/'.$bundle.'/Controllers/'.ucfirst($controller).'.php')){
                    return $fail->controller($controller);
                }
                elseif(!method_exists($routing, $action)){
                    return $fail->action($action);
                }
            }
            else{
                $route = (empty($path)) ? '' : implode('/', $path);
                return $fail->route($route);
            }
        }
    }