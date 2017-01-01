<?php
	namespace LFW\Framework\Controller;
    use LFW\Framework\DIC\Dic;
	use LFW\Framework\Template\Loader;

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
         * Templating constructor.
         * @param Dic $dic
         */
		public function __construct(Dic $dic){
            $this->dic = $dic;
		}

        /**
         * @param string $file
         * @param array $param
         * @return bool
         */
		public function view(string $file, array $param = []): bool{
            $loader = new Loader($file, $param, $this->dic);
            $loader->view();

            return true;
		}

        public function internal(string $type, string $link, string $file, array $param = []): bool{
            $loader = new Loader($link, $param, $this->dic);
            $loader->internal($type, $file);

            return true;
        }
	}