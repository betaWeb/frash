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
         * @param string|array $bundle
         * @param array $param
         * @return bool
         */
		public function view(string $file, $bundle = '', array $param = []): bool{
            if(!is_array($bundle) && !empty($bundle)){
                $this->bundle = $bundle;
                $params = $param;
            }
            else{
                $params = $bundle;
            }

            $loader = new Loader($file, $params, $this->dic);
            $loader->view();

            return true;
		}
	}