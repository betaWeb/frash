<?php
	namespace LFW\Framework\Template\Extensions;

    /**
     * Class Escape
     * @package LFW\Framework\Template\Extensions
     */
	class Escape{
        /**
         * @param array $escaping
         * @return string
         */
		public function parse($escaping){
			$code = '		private function escape'.md5($escaping[1]).'(){'."\n";
			$code .= '			return \''.trim(htmlentities($escaping[1])).'\';'."\n";
			$code .= '		}'."\n\n";

			return $code;
		}
	}