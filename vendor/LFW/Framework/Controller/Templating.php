<?php
	namespace LFW\Framework\Controller;
    use LFW\Framework\DIC\Dic;
	use LFW\Framework\Templating\Loader;

	class Templating{
        /**
         * @var string
         */
        private $bundle = '';

        /**
         * @var string
         */
        private $cache = '';

        /**
         * @var string
         */
        private $env = '';

        /**
         * @var string
         */
        private $lang = '';

        /**
         * @var array
         */
        private $nurl = [];

		public function __construct(Dic $dic){
            $gets = $dic->open('get');
            $this->bundle = $gets->get('bundle');
            $this->cache = $gets->get('cache_twig');
            $this->env = $gets->get('env');
            $this->lang = $gets->get('lang');
            $this->nurl = explode('/', $gets->get('uri'));
		}

		public function view($file, $bundle = '', $param = []){
            if(!is_array($bundle) && !empty($bundle)){
                $this->bundle = $bundle;
                $params = $param;
            }
            else{
                $params = $bundle;
            }

            $list = [
            	'bundle' => $this->bundle,
                'cache' => $this->cache,
                'env' => $this->env,
                'lang' => $this->lang,
            	'nurl' => $this->nurl,
            	'param' => $params
            ];

            $loader = new Loader($file, $list);
            $loader->view();
		}
	}