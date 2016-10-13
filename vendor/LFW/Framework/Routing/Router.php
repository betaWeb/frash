<?php
    namespace LFW\Framework\Routing;
    use LFW\Framework\CreateLog\CreateHTTPLog;
    use LFW\Framework\Exception\Exception;
    use LFW\Framework\DIC\Dic;
    use Symfony\Component\Yaml\Yaml;

    /**
     * Class Router
     * @package LFW\Framework\Routing
     */
    class Router{
        /**
         * @param string $url
         * @param Dic $dic
         * @return object
         */
        public function routing($url, Dic $dic){
            $conf = Yaml::parse(file_get_contents('vendor/LFW/Configuration/config.yml'));
            $gets = $dic->load('get');
            new CreateHTTPLog($url);

            $path = explode('/', $url);
            $route = '';
            $nb_expl = 0;
            $lien = '';

            $gets->set('uri', $url);
            $gets->set('yaml', $conf);

            if('/'.$path[0] == $conf['prefix'] && !empty($path[0])){
                if(in_array($path[1], $conf['traduction']['available'])){
                    $gets->set('lang', $path[1]);
                    unset($path[0], $path[1]);
                }
                elseif(!in_array($path[1], $conf['traduction']['available'])){
                    $gets->set('lang', $conf['traduction']['default']);

                    $slice = array_slice($path, 1);
                    $path = $slice;
                }
            }
            elseif(in_array($path[0], $conf['traduction']['available'])){
                $gets->set('lang', $path[0]);
                unset($path[0]);
            }
            else{
                $gets->set('lang', $conf['traduction']['default']);
            }

            array_unshift($path, 0);
            array_shift($path);

            $racine = 0;
            $routarr = Yaml::parse(file_get_contents('vendor/LFW/Configuration/'.$conf['routing']['file']));

            if(empty($path[0]) && !empty($conf['racine']['path'])){
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

            if($nb_expl > 0 && $lien != '' && $route != ''){
                $list = explode('/', str_replace($lien.'/', '', implode('/', $path)));

                $conf_get = (!empty($conf['racine']['get'])) ? $conf['racine']['get'] : [];
                $routarr_get = ($racine == 0) ? $routarr[ $lien ]['get'] : $conf_get;

                $gets->set('get', DefineGet::defineNormal($routarr_get, $list, $racine));

                list($bundle, $controller, $action) = explode(':', $route);
                $routing = 'Bundles\\'.$bundle.'\\Controllers\\'.$controller;

                if(method_exists($routing, $action)){
                    return $dic->load('controller', $dic)->call($routing)->$action($dic);
                }
                elseif(!file_exists('Bundles/'.$bundle.'/Controllers/'.ucfirst($controller).'.php')){
                    return new Exception('Controller '.$controller.' not found');
                }
                elseif(!method_exists($routing, $action)){
                    return new Exception('Action '.$action.' not found');
                }
            }
            else{
                $route = (empty($path)) ? '' : implode('/', $path);
                return new Exception('Route '.$route.' not found');
            }
        }
    }