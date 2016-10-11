<?php
    namespace LFW\Framework\Routing;
    use LFW\Framework\DIC\Dic;
    use Symfony\Component\Yaml\Yaml;

    /**
     * Class RouterDev
     * @package LFW\Framework\Routing
     */
    class RouterDev{
        public function routing($path, Dic $dic, $env){
            $rout_dev = Yaml::parse(file_get_contents('vendor/LFW/Configuration/routing_dev.yml'));

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