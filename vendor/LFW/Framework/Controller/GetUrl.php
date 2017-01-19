<?php
    namespace LFW\Framework\Controller;
    use LFW\Framework\DIC\Dic;

    /**
     * Class GetUrl
     * @package LFW\Framework\Controller
     */
    class GetUrl{
        private $prefix = '';

        /**
         * @param Dic $dic
         */
        public function __construct(Dic $dic){
            $this->prefix = $dic->get('prefix_lang');
        }

        /**
         * @param string $url
         * @param string $uri
         * @return string
         */
        public function url(string $url): string{
            return $this->prefix.'/'.$url;
        }
    }