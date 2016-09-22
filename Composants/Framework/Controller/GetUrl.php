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
         * @return string
         */
        public function url($url){
            $yaml = Yaml::parse(file_get_contents(self::CONFIG));
            $nurl = explode('/', ltrim(Server::getRequestUri(), '/'));

            if('/'.$nurl[0] == $yaml['prefix']){
                return (in_array($nurl[1], $yaml['traduction']['available'])) ? '/'.$nurl[0].'/'.$nurl[1].'/'.$url : '/'.$nurl[0].'/'.$url;
            }
            else{
                return (in_array($nurl[0], $yaml['traduction']['available'])) ? '/'.$nurl[0].'/'.$url : $url;
            }
        }
    }