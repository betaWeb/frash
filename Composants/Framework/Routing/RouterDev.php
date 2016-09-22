<?php
    namespace Composants\Framework\Routing;
    use Composants\Framework\DIC\Dic;
    use Composants\Yaml\Yaml;

    /**
     * Class RouterDev
     * @package Composants\Framework\Routing
     */
    class RouterDev{
        public function routing($path, Dic $dic, $env){
            $rout_dev = Yaml::parse(file_get_contents('Composants/Configuration/routing_dev.yml'));

            if(isset($rout_dev[ $path[0] ]) && $env == 'local'){
                $route = $rout_dev[ $path[0] ]['path'];

                if(file_exists($route.'.php')){
                    $action = $rout_dev[ $path[0] ]['action'];
                    $path_route = str_replace('/', '\\', $route);

                    $kget = $rout_dev[ $path[0] ]['get'];
                    unset($path[0]);

                    $gets = DefineGet::defineDev($path, $kget);
                    if(!empty($gets)){
                        $dic->open('get')->set('get', $gets);
                    }

                    $rout = new $path_route;
                    return $rout->$action($dic);
                }
            }
        }
    }