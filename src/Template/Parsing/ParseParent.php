<?php
namespace Frash\Template\Parsing;
use Frash\Template\{ DependTemplEngine, RegexParse };

/**
 * Class ParseParent
 * @package Frash\Template\Parsing
 */
class ParseParent extends RegexParse
{
    /**
     * @var array
     */
    private $attributes = [
        'bundle' => '',
        'tpl' => '',
        'level' => [ 'condition' => 0, 'esc_tpl' => 0, 'for' => 0, 'foreach' => 0, 'index' => 0, 'itvl' => 0 ],
        'count' => [ 'general' => 0, 'condition' => 0, 'esc_tpl' => 0, 'for' => 0, 'foreach' => 0, 'index' => 0, 'itvl' => 0, 'part' => 0 ],
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
     * ParseParent constructor.
     * @param object $trad
     * @param string $bundle
     * @param DependTemplEngine $dic_t
     */
	public function __construct($trad, string $bundle, DependTemplEngine $dic_t){
		$this->attributes['bundle'] = $bundle;
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
     * @param string $name
     * @param string $value
     * @return string
     */
	public function parse(string $name, string $value): string{
		$this->attributes['tpl'] = $value;
		preg_match_all('/\{\{ (([a-zA-Z_]*)?\s?([a-zA-Z0-9\/@\$\_!=:;+",<>\[\]\(\)\-\.\s]*)) \}\}/', $this->attributes['tpl'], $res_split, PREG_SET_ORDER);
		foreach($res_split as $key => $tag){
			switch(true){
				case $this->attributes['level']['esc_tpl'] == 0:
					switch(true){
                        case preg_match($this->extension['bundle'], $tag[0]):
                            $ext = $this->dic_t->callExtension()->parseParent('BundleParse', 'parse', $this->attributes, [ 'match' => $res_split[ $key ] ]);
                            $this->returnExtension($ext);
                            break;
						case preg_match($this->extension['condition']['else'], $tag[0]):
                            $ext = $this->dic_t->callExtension()->parse('ConditionParse', 'typeElse', $this->attributes, [ 'condition' => $res_split[ $key ][1] ]);
                            $this->returnExtension($ext);
							break;
						case preg_match($this->extension['condition']['elseif'], $tag[0]):
							break;
						case preg_match($this->extension['condition']['end'], $tag[0]):
                            $ext = $this->dic_t->callExtension()->parse('ConditionParse', 'typeEnd', $this->attributes, [ 'condition' => $res_split[ $key ][2] ]);
                            $this->returnExtension($ext);
							break;
						case preg_match($this->extension['condition']['if'], $tag[0]):
                            $ext = $this->dic_t->callExtension()->parse('ConditionParse', 'typeIf', $this->attributes, [ 'condition' => $res_split[ $key ][1] ]);
                            $this->returnExtension($ext);
							break;
                        case preg_match($this->extension['loop']['foreach']['close'], $tag[0]):
                            $ext = $this->dic_t->callExtension()->parse('ForeachParse', 'close', $this->attributes, [ 'match' => $res_split[ $key ], 'parsing' => $this->extension ]);
                            $this->returnExtension($ext);
                            break;
                        case preg_match($this->extension['loop']['foreach']['open'], $tag[0]):
                            $ext = $this->dic_t->callExtension()->parse('ForeachParse', 'open', $this->attributes, [ 'match' => $res_split[ $key ] ]);
                            $this->returnExtension($ext);
                            break;
                        case preg_match($this->extension['public'], $tag[0]):
                            $value = str_replace($res_split[ $key ][0], $this->dic_t->extension('Public')->parse($res_split[ $key ][4]), $value);
                            break;
						case preg_match($this->extension['route'], $tag[0]):
                            $ext = $this->dic_t->callExtension()->parseParent('RouteParent', 'parse', $this->attributes, [ 'match' => $res_split[ $key ] ]);
                            $this->returnExtension($ext);
							break;
						case preg_match($this->extension['show_var'], $tag[0]):
							if($this->attributes['level']['foreach'] == 0 && $this->attributes['level']['for'] == 0 && $this->attributes['level']['index'] == 0 && $this->attributes['level']['itvl'] == 0){
								$value = str_replace($res_split[ $key ][0], $this->dic_t->extension('ShowVar')->parse($res_split[ $key ][4]), $value);
							}

							break;
                        case preg_match($this->extension['traduction'], $tag[0]):
                            $key_trad = $res_split[ $key ][3];
                            $this->attributes['tpl'] = str_replace($res_split[ $key ][0], str_replace('\'', "\'", $this->trad->$key_trad), $this->attributes['tpl']);
                            break;
					}

					break;
			}
		}

		$complement = '	public function parent'.ucfirst($name).'(){'."\n";
		$complement .= '		$content = \''.trim($this->attributes['tpl']).'\';'."\n\n";
		$complement .= '		return $content;'."\n";
		$complement .= '	}'."\n\n";

		return $complement;
	}
}