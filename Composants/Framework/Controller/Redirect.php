<?php
    namespace Composants\Framework\Controller;
    use Composants\Framework\DIC\Dic;

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
         * @param Dic $dic
         */
        public function __construct(Dic $dic){
            $gets = $dic->open('get');

            $this->yaml = $gets->get('yaml');
            $this->nurl = explode('/', $gets->get('uri'));
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