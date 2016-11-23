<?php
	namespace LFW\Framework\Template\Extensions;

    /**
     * Class Part
     * @package LFW\Framework\Template\Extensions
     */
	class Part{
        /**
         * @param string $part
         * @param string $name
         * @param array $incl_parent
         * @return string
         */
		public function parse($part, $name, $incl_parent){
			preg_match('/\[parent (\w+)\]/', $part, $name_parent);
			
			if(!empty($name_parent[1])){
				$child = str_replace('[parent '.$name_parent[1].']', $incl_parent[$name_parent[1]], $part);
			}
			else{
				$child = $part;
			}

			$code = '		public function part'.ucfirst($name).'(){'."\n";
			$code .= '			return \''.trim($child).'\';'."\n";
			$code .= '		}'."\n\n";

			return $code;
		}
	}