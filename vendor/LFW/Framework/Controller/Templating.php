<?php
	namespace LFW\Framework\Controller;
    use LFW\Framework\DIC\Dic;
	use LFW\Framework\Template\Loader;

	class Templating{
        private $dic;

		public function __construct(Dic $dic){
            $this->dic = $dic;

            $gets = $dic->open('get');
            $this->cache = $gets->get('cache_twig');
            $this->env = $gets->get('env');
		}

		public function view($file, $bundle = '', $param = []){
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