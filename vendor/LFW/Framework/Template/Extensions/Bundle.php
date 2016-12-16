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

			$base = '/Bundles/'.$bundle.'/Ressources/'.$file;

			if('/'.$this->params['nurl'][0] == $this->params['json']['prefix'] && $this->params['json']['prefix'] != '/'){
                return '/'.$this->params['nurl'][0].$base;
            }
            else{
                return $base;
            }
		}
	}