<?php
	namespace LFW\Framework\Templating\Extensions\Import;

	class ImportRessourcesBundle{
		public static function parse($ressource, $params){
            $json = json_decode(file_get_contents('Configuration/config.json'), true);

            if(strstr($ressource, ' ')){
				list($file, $bundle) = explode(' ', $ressource);
			}
			else{
				$file = $ressource;
				$bundle = $params->bundle;
			}

			$base = '/Bundles/'.$bundle.'/Ressources/'.$file;

			if('/'.$params->nurl == $json['prefix'] && $json['prefix'] != '/'){
                return '/'.$params->nurl.$base;
            }
            else{
                return $base;
            }
		}
	}