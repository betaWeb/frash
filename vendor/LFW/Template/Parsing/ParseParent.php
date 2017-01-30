<?php
namespace LFW\Template\Parsing;
use LFW\Template\DependTemplEngine;
use LFW\Template\Parsing\ParseArray;

/**
 * Class ParseParent
 * @package LFW\Template\Parsing
 */
class ParseParent extends ParseArray{
    /**
     * @var string
     */
	private $bundle = '';

	/**
	 * @var DependTemplEngine
	 */
	private $dic_t;

    /**
     * @var string
     */
	private $tpl = '';

    /**
     * @var string
     */
	private $trad = '';

    /**
     * ParseParent constructor.
     * @param object $trad
     * @param string $bundle
     * @param string $tpl
     * @param DependTemplEngine $dic_t
     */
	public function __construct($trad, string $bundle, string $tpl, DependTemplEngine $dic_t){
		$this->bundle = $bundle;
		$this->dic_t = $dic_t;
		$this->tpl = $tpl;
		$this->trad = $trad;
	}

    /**
     * @param string $name
     * @param string $value
     * @return string
     */
	public function parse(string $name, string $value): string{
		$condition = [];

		$level_condition = 0;
		$level_escape = 0;
		$level_for_index = 0;
		$level_for_itvl = 0;
		$level_for_simple = 0;
		$level_foreach = 0;

		$treatment = '';
		preg_match_all('/\[(\/?)(([a-z]*)?\s?([a-zA-Z0-9\/@_!=:",\.\s]*))\]/', $value, $res_split, PREG_SET_ORDER);
		foreach($res_split as $key => $tag){
			switch(true){
				case $level_escape == 0:
					switch(true){
						case preg_match($this->parsing['else'], $tag[0]):
							$condition[ $level_condition ][] = [ 'type' => 'else', 'condition' => 'else' ];
							break;
						case preg_match($this->parsing['elseif'], $tag[0]):
							$condition[ $level_condition ][] = [ 'type' => 'elseif', 'condition' => $res_split[ $key ][2] ];
							break;
						case preg_match($this->parsing['end_condition'], $tag[0]):
							$condition[ $level_condition ][] = [ 'type' => 'end', 'condition' => '/condition' ];

							$cp = $this->dic_t->load('Condition')->parse($condition[ $level_condition ], $value);
							$treatment .= $cp['code'];
							$value = str_replace($cp['replace'], '\'.$this->'.$cp['name'].'().\'', $value);

							unset($condition[ $level_condition ]);
							$level_condition--;
							break;
						case preg_match($this->parsing['if'], $tag[0]):
							$level_condition++;
							$condition[ $level_condition ][] = [ 'type' => 'if', 'condition' => $res_split[ $key ][2] ];
							break;
						case preg_match($this->parsing['route'], $tag[0]):
							if($level_foreach == 0 && $level_for_simple == 0 && $level_for_index == 0 && $level_for_itvl == 0){
								$value = str_replace($res_split[ $key ][0], $this->dic_t->load('Route')->parse($res_split[ $key ][4]), $value);
							}

							break;
						case preg_match($this->parsing['show_var'], $tag[0]):
							if($level_foreach == 0 && $level_for_simple == 0 && $level_for_index == 0 && $level_for_itvl == 0){
								$value = str_replace($res_split[ $key ][0], $this->dic_t->load('ShowVar')->parse($res_split[ $key ][4]), $value);
							}

							break;
					}

					break;
			}
		}

		$complement = '		public function parent'.ucfirst($name).'(){'."\n";
		$complement .= '		return \''.trim($value).'\';'."\n";
		$complement .= '	}'."\n\n";

		return $complement.$treatment;
	}
}