<?php
	namespace LFW\Framework\Template\Cache;
	use LFW\Framework\Template\DependTemplEngine;

	class ImportBottomBar{
		private $dic;
		private $dic_t;

		public function __construct($dic, DependTemplEngine $dic_t){
			$dic->open('microtime')->setMicrotime('bottom_bar');
			$this->dic = $dic;
			$this->dic_t = $dic_t;
		}

		public function parse(){
			$microtime = $this->dic->open('microtime');

			$code = '<div id="tpl_bottom_bar">'."\n";
			$code .= '			'.$microtime->getTiming('start', 'bottom_bar')."\n";
			$code .= '		</div>'."\n";

			return $code;
		}
	}