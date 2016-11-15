<?php
	namespace LFW\Framework;

    /**
     * Class UpperCamelCase
     * @package LFW\Framework
     */
	class UpperCamelCase{
		/**
         * @param string $str
         */
		private static $str = '';

        /**
         * @param string $string
         * @return string
         */
		public static function treatment($string){
			self::$str = $string;
			self::recursive();

			return self::$str;
		}

		private static function recursive(){
			if(strstr(self::$str, '_')){
				$pos = strpos(self::$str, '_');
				$next = self::$str[ $pos + 1 ];
				
				if(ctype_alpha($next)){
					self::$str[ $pos + 1 ] = ucfirst($next);
					self::$str[ $pos ] = '';
				}

				if(strstr(self::$str, '_')){
					self::recursive();
				}
			}
		}
	}