<?php
	namespace LFW\Framework\Template\Parsing;
	use LFW\Framework\Template\Cache\Bundle;
	use LFW\Framework\Template\Cache\Route;
	use LFW\Framework\Template\Parsing\ParseArray;

	class ParseParent extends ParseArray{
		private $bundle = '';
		private $tpl = '';
		private $trad = '';

		public function __construct($trad, $bundle, $tpl){
			$this->bundle = $bundle;
			$this->tpl = $tpl;
			$this->trad = $trad;
		}

		public function parse($name, $value){
			$level_escape = 0;
			$level_part = 0;

			$complement = '		public function parent'.ucfirst($name).'(){'."\n";
			$complement .= '			return \''.trim($value).'\';'."\n";
			$complement .= '		}'."\n\n";

			$treatment = '';
			preg_match_all('/\[(\/?)(([a-z]*)?\s?([a-z\/@_!=:,\.\s]*))\]/', $value, $res_split, PREG_SET_ORDER);
			foreach($res_split as $key => $tag){
				switch(true){
					case (preg_match($this->parsing['escape'], $tag[0])):
						break;
					case (preg_match($this->parsing['end_escape'], $tag[0])):
						break;
					case $level_escape == 0:
						switch(true){
							case preg_match($this->parsing['bundle'], $tag[0]):
								break;
							case preg_match($this->parsing['route'], $tag[0]):
								break;
							case preg_match($this->parsing['traduction'], $tag[0]):
								break;
							case preg_match($this->parsing['foreach'], $tag[0]):
								break;
							case preg_match($this->parsing['end_foreach'], $tag[0]):
								break;
							case preg_match($this->parsing['set_var'], $tag[0]):
								break;
							case preg_match($this->parsing['show_var'], $tag[0]):
								break;
						}

						break;
				}
			}

			return $complement.$treatment;
		}
	}