<?php
	namespace LFW\Framework\Template\Cache;
    use LFW\Framework\DIC\Dic;
	use LFW\Framework\Template\DependTemplEngine;

    /**
     * Class ImportBottomBar
     * @package LFW\Framework\Template\Cache
     */
	class ImportBottomBar{
        /**
         * @var Dic
         */
		private $dic;

        /**
         * @var DependTemplEngine
         */
		private $dic_t;

        /**
         * ImportBottomBar constructor.
         * @param Dic $dic
         * @param DependTemplEngine $dic_t
         */
		public function __construct(Dic $dic, DependTemplEngine $dic_t){
			$dic->open('microtime')->setMicrotime('bottom_bar');
			$this->dic = $dic;
			$this->dic_t = $dic_t;
		}

        /**
         * @return string
         */
		public function parse(){
			$microtime = $this->dic->open('microtime');

			$code = '<div id="tpl_bottom_bar">'."\n";
			$code .= '			'.$microtime->getTiming('start', 'bottom_bar')."\n";
			$code .= '		</div>'."\n";

			return $code;
		}
	}