<?php
	namespace LFW\Framework\Template\Extensions;
    use LFW\Framework\Template\DependTemplEngine;

    /**
     * Class Bundle
     * @package LFW\Framework\Template\Extensions
     */
	class Bundle{
        /**
         * @var array
         */
		private $params = [];

        /**
         * Bundle constructor.
         * @param DependTemplEngine $dic_t
         * @param array $params
         */
		public function __construct(DependTemplEngine $dic_t, array $params){
			$this->params = $params;
		}

        /**
         * @param string $path
         * @param string $bundle
         * @return string
         */
		public function parse(string $path, string $bundle): string{
            if(strstr($path, '::')){
				list($bundle, $file) = explode('::', $path);
			}
			else{
				$file = $path;
			}

            $prefix = ($this->params['prefix'] == '/') ? '' : $this->params['prefix'];
            return $prefix.'/Bundles/'.$bundle.'/Ressources/'.$file;
		}

        /**
         * @param string $path
         * @return string
         */
        public function internal(string $path): string{
            $prefix = ($this->params['prefix'] == '/') ? '' : $this->params['prefix'];
            return $prefix.'/'.$path;
        }
	}