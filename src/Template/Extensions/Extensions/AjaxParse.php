<?php
namespace Frash\Template\Extensions\Extensions;
use Frash\Template\DependTemplEngine;
use Frash\Template\Extensions\Extend\ExtensionParseTplParent;

/**
 * Class AjaxParse
 * @package Frash\Template\Extensions\Extensions
 */
class AjaxParse extends ExtensionParseTplParent{
    /**
     * @var DependTemplEngine
     */
	private $dic_t;

    /**
     * @var array
     */
	private $params = [];

    /**
     * AjaxParse constructor.
     * @param DependTemplEngine $dic_t
     * @param array $params
     */
	public function __construct(DependTemplEngine $dic_t, array $params){
		$this->dic_t = $dic_t;
		$this->params = $params;
	}

	public function parse(){
		$prefix = '\\\''.$this->params['prefix'].'\\\'';
		$prefix_lang = '\\\''.$this->params['prefix_lang'].'\\\'';

		$code = '	<script>'."\n";
		$code .= '		var prefix = '.$prefix.';'."\n";
		$code .= '		var prefix_lang = '.$prefix_lang.';'."\n";
		$code .= '	</script>'."\n";

        $this->infos['tpl'] = str_replace('{{ ajax }}', $code, $this->infos['tpl']);
	}
}