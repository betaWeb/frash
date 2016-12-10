<?php
	namespace LFW\DocGen\Treatment\Create;

	class Summary{
		public static function work($output, $class, $prefix){
			$code = '';
            foreach($class as $c){
                $path = str_replace('\\', '/', $c);
                $code .= '                  <a href="'.$prefix.'/'.$output.'/'.$path.'.html">'.$path.'</a><br>'."\n";
            }

            return $code;
		}
	}