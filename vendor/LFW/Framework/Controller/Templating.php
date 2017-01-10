<?php
	namespace LFW\Framework\Controller;
    use LFW\Framework\DIC\Dic;
	use LFW\Template\Loader;

    /**
     * Class Templating
     * @package LFW\Framework\Controller
     */
	class Templating{
        /**
         * @var Dic
         */
        private $dic;

        /**
         * @var array
         */
        private $extensions = [];

        /**
         * @var boolean
         */
        private $no_cache = false;

        /**
         * Templating constructor.
         * @param Dic $dic
         */
		public function __construct(Dic $dic){
            $this->dic = $dic;
		}

        /**
         * @param string $regex
         * @param string $class
         */
        public function setExtension(string $regex, string $class){
            $this->extensions[ $regex ] = $class;
        }

        public function noCache(){
            $this->no_cache = true;
        }

        /**
         * @param array $params
         * @return array
         */
        public function getInternalParam(array $params): array{
            $gets = $this->dic->load('get');
            return array_merge([ 'internal_prefix' => $gets->get('prefix'), 'internal_prefix_lang' => $gets->get('prefix_lang') ], $params);
        }

        /**
         * @param string $file
         * @param array $param
         * @return bool
         */
		public function view(string $file, array $param = []): bool{
            $loader = new Loader($file, $this->getInternalParam($param), $this->dic, $this->extensions);
            $loader->view($this->no_cache);

            return true;
		}

        /**
         * @param string $type
         * @param string $link
         * @param string $file
         * @param array $param
         * @return bool
         */
        public function internal(string $type, string $link, string $file, array $param = []): bool{
            $loader = new Loader($link, $this->getInternalParam($param), $this->dic, $this->extensions);
            $loader->internal($type, $file);

            return true;
        }
	}