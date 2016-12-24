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
         * @var string
         */
        private $prefix = '';

        /**
         * Redirect constructor.
         * @param Dic $dic
         */
        public function __construct(Dic $dic){
            $gets = $dic->load('get');

            $this->nurl = explode('/', $gets->get('uri'));
            $this->prefix = $gets->get('prefix_lang');
        }

        /**
         * @param string $url
         * @return bool
         */
        public function route(string $url): bool{
            header('Location:'.$this->prefix.'/'.$url);
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