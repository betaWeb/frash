<?php
	namespace LFW\Framework\Templating\Extensions;

	class Routes{
		private static $prefix = '';
		private static $trad = [];

		public static function setJson(){
			$json = json_decode(file_get_contents('Configuration/config.json'), true);
			self::$prefix = $json['prefix'];
			self::$trad = $json['traduction']['available'];
		}

		public static function parse($route, $nurl){
			if('/'.$nurl[0] == self::$prefix && self::$prefix != '/'){
                if(in_array($nurl[1], self::$trad)){
                    return '/'.$nurl[0].'/'.$nurl[1].'/'.$route;
                }
                else{
                    return '/'.$nurl[0].'/'.$route;
                }
            }
            else{
                if(in_array($nurl[0], self::$trad)){
                    return '/'.$nurl[0].'/'.$route;
                }
                else{
                    return $route;
                }
            }
		}
	}