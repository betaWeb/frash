<?php
	namespace LFW\Framework\Template\Extensions\BottomBar;
    use LFW\Framework\DIC\Dic;
	use LFW\Framework\Template\DependTemplEngine;

    /**
     * Class ImportBottomBar
     * @package LFW\Framework\Template\Extensions\BottomBar
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
         * @var string
         */
        private $prefix = '';

        /**
         * ImportBottomBar constructor.
         * @param Dic $dic
         * @param DependTemplEngine $dic_t
         */
		public function __construct(Dic $dic, DependTemplEngine $dic_t){
			$dic->load('microtime')->setMicrotime('bottom_bar');
			$this->dic = $dic;
            $this->prefix = $this->dic->load('get')->get('prefix');
			$this->dic_t = $dic_t;
		}

        /**
         * @return string
         */
		public function parse(){
			$microtime = $this->dic->load('microtime');
            $analyzer = $this->dic->load('getUrl')->url('__analyzer/').$this->dic->load('get')->get('url_analyzer');

            $code = '<link rel="stylesheet" media="screen" type="text/css" href="'.$this->prefix.'/vendor/LFW/Framework/Template/Cache/bottom_bar.css">'."\n";
			$code .= '<div id="tpl_bottom_bar">'."\n";
			$code .= '			<div class="middle float_left time">Time : '.$microtime->getTiming('start', 'bottom_bar').'</div>'."\n";
            $code .= '          <div class="middile float_right analyzer"><a href="'.$analyzer.'">Analyzer</a></div>'."\n";
			$code .= '		</div>'."\n";

			return $code;
		}
	}