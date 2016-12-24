<?php
    namespace LFW\Framework\Controller;
    use LFW\Framework\DIC\Dic;
    use LFW\Framework\FileSystem\Json;
    use LFW\Framework\Globals\Server;

    /**
     * Class GetUrl
     * @package LFW\Framework\Controller
     */
    class GetUrl{
        /**
         * @param Dic $dic
         */
        public function __construct(Dic $dic){
            $this->prefix = $dic->load('get')->get('prefix_lang');
        }

        /**
         * @param string $url
         * @param string $uri
         * @return string
         */
        public function url(string $url, string $uri = ''): string{
            return $this->prefix.'/'.$url;
        }
    }