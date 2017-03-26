<?php
namespace Frash\Template\Extensions\BottomBar;
use Frash\Framework\DIC\Dic;
use Frash\Template\DependTemplEngine;

/**
 * Class ImportBottomBar
 * @package Frash\Template\Extensions\BottomBar
 */
class ImportBottomBar{
    const PATH = 'vendor/alixsperoza/frash/ressources';

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
        $this->dic = $dic;
		$this->dic->load('microtime')->set('bottom_bar');
        $this->prefix = $this->dic->prefix;
		$this->dic_t = $dic_t;
	}

    /**
     * @return string
     */
	public function parse(): string{
		$microtime = $this->dic->load('microtime');
        $dump = $this->dic_t->getParam('params')['dump'];
        $analyzer = $this->dic->load('getUrl')->url('__analyzer/');

        if(!empty($this->dic->url_analyzer)){
            $analyzer .= $this->dic->url_analyzer;
        }

        $code = '       <link rel="stylesheet" media="screen" type="text/css" href="'.$this->prefix.'/'.self::PATH.'/css/bottom_bar.css">'."\n";
		$code .= '      <div id="tpl_bottom_bar">'."\n";
        $code .= '          <div id="bottom_bar">'."\n";
		$code .= '			    <div class="middle float_left time">Time : '.$microtime->getTiming('start', 'bottom_bar').'</div>'."\n";
        $code .= '              <div class="middle float_right">'."\n";
        $code .= '                  <div class="dump float_left"><a id="href_dump" href="#">Dump</a></div>'."\n";
        $code .= '                  <div class="analyzer float_left"><a href="'.$analyzer.'">Analyzer</a></div>'."\n";
        $code .= '              </div>'."\n";
        $code .= '          </div>'."\n";

        if(!empty($dump)){
            $list_name = [];

            $code .= '          <div class="div_dump display_none">'."\n";
            $code .= '              <div class="list_dump float_left">'."\n";
            $code .= '                  <ul>'."\n";
                                            foreach($dump as $name => $v){
                                                $list_name[] = $name;
                                                $code .= '                  <li><a class="name_dump" id="'.$name.'" href="#'.$name.'">'.$name.'</a></li>'."\n";
                                            }
            $code .= '                  </ul>'."\n";
            $code .= '              </div>'."\n";
            $code .= '              <span id="names_dump" class="display_none">'.implode('/', $list_name).'</span>'."\n";
            $code .= '              <div class="content_dump float_left">'."\n";
                                        foreach($dump as $name => $value){
                                            $code .= '                  <div id="content_'.$name.'" class="content display_none">'."\n";
                                            $code .= '                      <pre>'.print_r($value, true).'</pre>'."\n";
                                            $code .= '                  </div>'."\n";
                                        }
            $code .= '              </div>'."\n";
            $code .= '          </div>'."\n";
        }

		$code .= '		</div>'."\n";
        $code .= '      <script src="'.$this->prefix.'/'.self::PATH.'/javascript/bottom_bar.js"></script>'."\n";

		return $code;
	}
}