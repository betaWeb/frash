<?php
namespace Frash\Template\Parsing;
use Frash\Template\DependTemplEngine;
use Frash\Template\Parsing\ParseArray;

/**
 * Class ParseParent
 * @package Frash\Template\Parsing
 */
class ParseParent extends ParseArray{
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
		preg_match_all('/\{\{ (([a-zA-Z_]*)?\s?([a-zA-Z0-9\/@_!=:;+",<>\(\)\-\.\s]*)) \}\}/', $this->attributes['tpl'], $res_split, PREG_SET_ORDER);
		foreach($res_split as $key => $tag){
			switch(true){
				case $this->attributes['level']['escape_tpl'] == 0:
					switch(true){
						case preg_match($this->extension['default']['else'], $tag[0]):
							$condition[ $this->attributes['level']['condition'] ][] = [ 'type' => 'else', 'condition' => 'else' ];
							break;
						case preg_match($this->extension['default']['elseif'], $tag[0]):
							$condition[ $this->attributes['level']['condition'] ][] = [ 'type' => 'elseif', 'condition' => $res_split[ $key ][2] ];
							break;
						case preg_match($this->extension['default']['end_condition'], $tag[0]):
							$condition[ $this->attributes['level']['condition'] ][] = [ 'type' => 'end', 'condition' => '/condition' ];

							$cp = $this->dic_t->extension('Condition')->parse($condition[ $this->attributes['level']['condition'] ], $value);
							$this->attributes['tpl'] .= $cp['code'];
							$value = str_replace($cp['replace'], '\'.$this->'.$cp['name'].'().\'', $value);

							unset($condition[ $this->attributes['level']['condition'] ]);
                            $this->attributes['level']['condition']--;
							break;
						case preg_match($this->extension['default']['if'], $tag[0]):
                            $this->attributes['level']['condition']++;
							$condition[ $this->attributes['level']['condition'] ][] = [ 'type' => 'if', 'condition' => $res_split[ $key ][2] ];
							break;
                        case preg_match($this->extension['default']['public'], $tag[0]):
                            $value = str_replace($res_split[ $key ][0], $this->dic_t->extension('Public')->parse($res_split[ $key ][4]), $value);
                            break;
						case preg_match($this->extension['default']['route'], $tag[0]):
                            $ext = $this->dic_t->callExtension()->parseParent('RouteParent', 'parse', $this->attributes, [ 'match' => $res_split[ $key ] ]);
                            $this->returnExtension($ext);
							break;
						case preg_match($this->extension['default']['show_var'], $tag[0]):
							if($this->attributes['level']['foreach'] == 0 && $this->attributes['level']['for'] == 0 && $this->attributes['level']['index'] == 0 && $this->attributes['level']['itvl'] == 0){
								$value = str_replace($res_split[ $key ][0], $this->dic_t->extension('ShowVar')->parse($res_split[ $key ][4]), $value);
							}

							break;
                        case preg_match($this->extension['default']['traduction'], $tag[0]):
                            $value_trad = $res_split[ $key ][4];
                            $value = str_replace($res_split[ $key ][0], str_replace('\'', "\'", $this->trad->$value_trad), $value);
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