<?php
namespace Frash\Template\Parsing;
use Frash\Template\DependTemplEngine;
use Frash\Template\Parsing\ParseArray;

/**
 * Class ParseTplParent
 * @package Frash\Template\Parsing
 */
class ParseTplParent extends ParseArray{
    /**
     * @var array
     */
    private $attributes = [
        'bundle' => '',
        'tpl' => '',
        'level' => [ 'condition' => 0, 'escape_tpl' => 0, 'for' => 0, 'foreach' => 0, 'index' => 0, 'itvl' => 0 ],
        'condition' => [],
        'foreach' => [],
        'function' => []
    ];

    /**
     * @var DependTemplEngine
     */
	private $dic_t;

    /**
     * @var string
     */
	private $trad = '';

    /**
     * ParseTplParent constructor.
     * @param object $trad
     * @param string $bundle
     * @param string $display
     * @param DependTemplEngine $dic_t
     */
	public function __construct($trad, string $bundle, string $display, DependTemplEngine $dic_t){
		$this->attributes['bundle'] = $bundle;
		$this->attributes['tpl'] = $display;
		$this->dic_t = $dic_t;
		$this->trad = $trad;
	}

    /**
     * @param object $return
     */
    private function returnExtension($return){
        $infos = $return->getInfos();
        $this->attributes['condition'] = $infos['condition'];
        $this->attributes['foreach'] = $infos['foreach'];
        $this->attributes['function'] = $infos['function'];
        $this->attributes['level'] = $infos['level'];
        $this->attributes['tpl'] = $infos['tpl'];
    }

    /**
     * @return string
     */
	public function parse(): string{
        preg_match_all('/\{\{ (([a-zA-Z_]*)?\s?([a-zA-Z0-9\/@_!=:;+",<>\[\]\(\)\-\.\s]*)) \}\}/', $this->attributes['tpl'], $res_split, PREG_SET_ORDER);
		foreach($res_split as $key => $tag){
			switch(true){
				case $this->attributes['level']['escape_tpl'] == 0:
					switch(true){
						case preg_match($this->extension['default']['bundle'], $tag[0]):
                            $ext = $this->dic_t->callExtension()->parse('BundleTplParent', 'parse', $this->attributes, [ 'match' => $res_split[ $key ] ]);
                            $this->returnExtension($ext);
							break;
                        case preg_match($this->extension['default']['public'], $tag[0]):
                            $this->display = str_replace($res_split[ $key ][0], $this->dic_t->extension('Public')->parse($res_split[ $key ][4]), $this->display);
                            break;
						case preg_match($this->extension['default']['route'], $tag[0]):
                            $ext = $this->dic_t->callExtension()->parseTplParent('RouteTplParent', 'parse', $this->attributes, [ 'match' => $res_split[ $key ] ]);
                            $this->returnExtension($ext);
							break;
						case preg_match($this->extension['default']['traduction'], $tag[0]):
                            $key_trad = $res_split[ $key ][3];
                            $this->attributes['tpl'] = str_replace($res_split[ $key ][0], str_replace('\'', "\'", $this->trad->$key_trad), $this->attributes['tpl']);
							break;
						case preg_match($this->extension['default']['show_var'], $tag[0]):
                            $this->display = str_replace($res_split[ $key ][0], $this->dic_t->extension('ShowVar')->parse($res_split[ $key ][4]), $this->display);
							break;
					}

					break;
			}
		}

		return $this->attributes['tpl'];
	}
}