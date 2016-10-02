<?php
    namespace Composants\Framework\Controller;
    use Composants\Framework\Globals\Server;
    use Composants\Yaml\Yaml;

    /**
     * Class Redirect
     * @package Composants\Framework\Controller
     */
    class Redirect{
        /**
         * @var array
         */
        private $yaml = [];

        /**
         * @var array
         */
        private $nurl = [];

        /**
         * Redirect constructor.
         * @param string $uri
         */
        public function __construct($uri){
            $this->yaml = Yaml::parse(file_get_contents('Composants/Configuration/config.yml'));
            $this->nurl = explode('/', $uri);
        }

        /**
         * @param string $url
         * @return bool
         */
        public function route($url){
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
        public function url($url){
            header('Location:'.$url);
            return true;
        }
    }