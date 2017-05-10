<?php
namespace Frash\Template\Extensions\Extensions\Loop\ForeachLoop;
use Frash\Template\DependTemplEngine;
use Frash\Template\Extensions\Extend\ExtensionParseForeach;

/**
 * Class ForeachParse
 * @package Frash\Template\Extensions\Extensions\Loop\ForeachLoop
 */
class ForeachParse extends ExtensionParseForeach{
	/**
	 * @var array
	 */
	private $attributes = [];

    /**
     * @var DependTemplEngine
     */
	private $dic_t;

    /**
     * @var array
     */
	private $params = [];

    /**
     * ForeachParse constructor.
     * @param DependTemplEngine $dic_t
     * @param array $params
     */
	public function __construct(DependTemplEngine $dic_t, array $params){
		$this->dic_t = $dic_t;
		$this->params = $params;
	}

	public function open(){
		$this->infos['level']['foreach']++;
        $this->infos['foreach'][ $this->infos['level']['foreach'] ] = [ 'foreach' => $this->infos['params']['match'][0], 'param' => $this->infos['params']['match'][3] ];
	}

	public function close(){
		$foreach = $this->infos['foreach'][ $this->infos['level']['foreach'] ]['param'];
		preg_match('/\{\{ foreach '.$foreach.' \}\}(.*)\{\{ end_foreach \}\}/Us', $this->infos['tpl'], $match);
		$this->content = $match[1];

		list($array, $param) = explode(' :: ', $foreach);
		list($k, $v) = explode(', ', $param);

		preg_match_all('/\{\{ (([a-zA-Z_]*)?\s?([a-zA-Z0-9\/@_!=:;+",<>\(\)\-\.\s]*)) \}\}/', $this->content, $match_all, PREG_SET_ORDER);
		foreach($match_all as $key => $tag){
			switch(true){
				case $this->infos['level']['esc_tpl'] == 0:
					switch(true){
						case preg_match($this->infos['params']['parsing']['route'], $tag[0]):
                            $infos = $this->dic_t->callExtension()->parseForeach('RouteForeach', 'parse', $this->infos, [ 'match' => $match_all[ $key ], 'params_foreach' => [ 'k' => $k, 'v' => $v ] ])->getInfos();
                            $this->content = str_replace($match_all[ $key ][0], $infos['content'], $this->content);
							break;
						case preg_match($this->infos['params']['parsing']['show_var_for'], $tag[0]):
                            $infos = $this->dic_t->callExtension()->parseForeach('ShowVarParseForeach', 'parse', $this->infos, [ 'match' => $match_all[ $key ], 'params_foreach' => [ 'k' => $k, 'v' => $v ] ])->getInfos();
                            $this->content = str_replace($match_all[ $key ][0], $infos['content'], $this->content);
							break;
					}

					break;
			}
		}

		if($array[0] != '!'){
			$expr = '$this->params[\''.$array.'\']';
		} else {
			$expr = '$'.$this->dic_t->extension('FormatVar')->parseForeach(ltrim($array, '!'));
		}

		$code = '\';'."\n\n";
		$code .= '		foreach('.$expr.' as $'.$k.' => $'.$v.'){'."\n";
		$code .= '			$content .= \''.trim($this->content).'\';'."\n";
		$code .= '		}'."\n\n";
		$code .= '		$content .= \'';
        
        $this->infos['tpl'] = str_replace($match[0], $code, $this->infos['tpl']);
        $this->infos['level']['foreach']--;
	}
}