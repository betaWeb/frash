<?php
    namespace LFW\Framework\Controller;
    use LFW\Framework\FileSystem\Json;
    use LFW\Framework\Globals\Server;

    /**
     * Class GetUrl
     * @package LFW\Framework\Controller
     */
    class GetUrl{
        /**
         * @param string $url
         * @param string $uri
         * @return string
         */
        public function url(string $url, string $uri = ''): string{
            $json = Json::importConfigArray();
            $nurl = ($uri == '') ? explode('/', Server::getReqUriTrim()) : explode('/', $uri);

            if('/'.$nurl[0] == $json['prefix'] && $json['prefix'] != '/'){
                return (in_array($nurl[1], $json['traduction']['available'])) ? '/'.$nurl[0].'/'.$nurl[1].'/'.$url : '/'.$nurl[0].'/'.$url;
            }
            else{
                return (in_array($nurl[0], $json['traduction']['available'])) ? '/'.$nurl[0].'/'.$url : '/'.$url;
            }
        }
    }