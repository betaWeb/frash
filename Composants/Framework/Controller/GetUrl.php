<?php
    namespace Composants\Framework\Controller;
    use Composants\Yaml\Yaml;

    /**
     * Class GetUrl
     * @package Composants\Framework\Controller
     */
    class GetUrl{
        const CONFIG = 'Composants/Configuration/config.yml';

        /**
         * @var array
         */
        private $nurl = [];

        /**
         * @var array
         */
        private $yaml = [];

        /**
         * @param string $url
         * @param string $base
         * @param mixed $prefix
         * @return string
         */
        public function url($url, $base = '', $prefix = false){
            $this->yaml = ($prefix === false) ? Yaml::parse(file_get_contents(self::CONFIG)) : Yaml::parse(file_get_contents($prefix.self::CONFIG));
            $this->nurl = explode('/', ltrim($base, '/'));

            if('/'.$this->nurl[0] == $this->yaml['prefix']){
                return (in_array($this->nurl[1], $this->yaml['traduction']['available'])) ? '/'.$this->nurl[0].'/'.$this->nurl[1].'/'.$url : '/'.$this->nurl[0].'/'.$url;
            }
        }
    }