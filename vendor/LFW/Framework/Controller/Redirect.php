<?php
    namespace LFW\Framework\Controller;
    use LFW\Framework\DIC\Dic;
    use LFW\Framework\FileSystem\Json;

    /**
     * Class Redirect
     * @package LFW\Framework\Controller
     */
    class Redirect{
        /**
         * @var array
         */
        private $nurl = [];

        /**
         * Redirect constructor.
         * @param Dic $dic
         */
        public function __construct(Dic $dic){
            $this->nurl = explode('/', $dic->load('get')->get('uri'));
        }

        /**
         * @param string $url
         * @return bool
         */
        public function route(string $url): bool{
            $json = Json::importConfigArray();
            
            if('/'.$this->nurl[0] == $json['prefix'] && $json['prefix'] != '/'){
                $redirect = (in_array($this->nurl[1], $json['traduction']['available'])) ? $this->nurl[0].'/'.$this->nurl[1] : $this->nurl[0];
            }
            else{
                $redirect = (in_array($this->nurl[0], $json['traduction']['available'])) ? $this->nurl[0] : '';
            }

            header('Location:/'.$redirect.'/'.$url);
            return true;
        }

        /**
         * @param string $url
         * @return bool
         */
        public function url(string $url): bool{
            header('Location:'.$url);
            return true;
        }
    }