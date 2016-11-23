<?php
	namespace LFW\Framework\Template\Cache;
	use LFW\Framework\Template\DependTemplEngine;

	class ImportBottomBar{
		private $dic_t;

		public function __construct(DependTemplEngine $dic_t){
			$this->dic_t = $dic_t;
		}

		public function parse(){
			$code = '<div id="tpl_bottom_bar">'."\n";
			$code .= '		</div>'."\n";

			return $code;
		}
	}