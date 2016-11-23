<?php
	namespace LFW\Framework\Template\Extensions;

	class Bundle{
		private $params;

		public function __construct($dte, $params){
			$this->params = $params;
		}

		public function parse($path, $bundle){
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