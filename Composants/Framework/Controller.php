<?php
    namespace Composants\Framework;
    use Composants\Framework\Globals\Server;
    use Composants\Yaml\Yaml;

    /**
     * Class Controller
     * @package Composants\Framework
     */
    class Controller{
        /**
         * @var array
         */
        private $yaml = [];

        /**
         * @var array
         */
        private $nurl = [];

        /**
         * Controller constructor.
         */
        public function __construct(){
            $this->yaml = Yaml::parse(file_get_contents('Composants/Configuration/config.yml'));
            $this->nurl = explode('/', ltrim(Server::getRequestUri(), '/'));
        }

        /**
         * @param string $url
         * @return bool
         */
        public function redirectToRoute($url){
            if('/'.$this->nurl[0] == $this->yaml['prefix']){
                $redirect = (in_array($this->nurl[1], $this->yaml['traduction']['available'])) ? $this->nurl[0].'/'.$this->nurl[1] : $this->nurl[0];

                header('Location:/'.$redirect.'/'.$url);
                return true;
            }

            return false;
        }

        /**
         * @param string $url
         * @return bool
         */
        public function redirectToUrl($url){
            header('Location:'.$url);
            return true;
        }

        /**
         * @param string $url
         * @return string
         */
        public function getUrl($url){
            if('/'.$this->nurl[0] == $this->yaml['prefix']){
                return (in_array($this->nurl[1], $this->yaml['traduction']['available'])) ? '/'.$this->nurl[0].'/'.$this->nurl[1].'/'.$url : '/'.$this->nurl[0].'/'.$url;
            }
            else{
                return (in_array($this->nurl[0], $this->yaml['traduction']['available'])) ? '/'.$this->nurl[0].'/'.$url : $url;
            }
        }
    }