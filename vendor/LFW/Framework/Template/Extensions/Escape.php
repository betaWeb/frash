<?php
	namespace LFW\Framework\Template\Extensions;

	class Escape{
		public function parse($escaping){
			$code = '		private function escape'.md5($escaping[1]).'(){'."\n";
			$code .= '			return \''.trim($escaping[1]).'\';'."\n";
			$code .= '		}'."\n\n";

			return $code;
		}
	}