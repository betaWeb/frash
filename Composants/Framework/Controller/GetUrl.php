<?php
    namespace Composants\Framework\Controller;
    use Composants\Framework\Globals\Server;
    use Composants\Yaml\Yaml;

    /**
     * Class GetUrl
     * @package Composants\Framework\Controller
     */
    class GetUrl{
        const CONFIG = 'Composants/Configuration/config.yml';

        /**
         * @param string $url
         * @param string $uri
         * @return string
         */
        public function url($url, $uri = ''){
            $yaml = Yaml::parse(file_get_contents(self::CONFIG));
            $nurl = ($uri == '') ? explode('/', ltrim(Server::getRequestUri(), '/')) : explode('/', $uri);

            if('/'.$nurl[0] == $yaml['prefix']){
                return (in_array($nurl[1], $yaml['traduction']['available'])) ? '/'.$nurl[0].'/'.$nurl[1].'/'.$url : '/'.$nurl[0].'/'.$url;
            }
            else{
                return (in_array($nurl[0], $yaml['traduction']['available'])) ? '/'.$nurl[0].'/'.$url : $url;
            }
        }
    }