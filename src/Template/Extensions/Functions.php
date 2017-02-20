<?php
namespace LFW\Template\Extensions;
use LFW\Template\DependTemplEngine;

/**
 * Class Functions
 * @package LFW\Template\Extensions
 */
class Functions{
    /**
     * @var DependTemplEngine
     */
	private $dic_t;

    /**
     * Functions constructor.
     * @param DependTemplEngine $dic_t
     */
	public function __construct(DependTemplEngine $dic_t){
		$this->dic_t = $dic_t;
	}

    /**
     * @param string $name
     * @param string $param
     * @param string $content
     * @return string
     */
	public function parse(string $name, string $param, string $content){
		$code = '	public function '.$name.'('.$this->parseParam($param).'){'."\n";
		$code .= '		'.$this->parseContent(trim($content))."\n";
		$code .= '	}'."\n\n";

		return $code;
	}

    /**
     * @param string $param
     * @return string
     */
	private function parseParam(string $param): string{
		$expl = explode(', ', $param);
		foreach($expl as $p){
			$impl[] = '$'.$p;
		}

		return implode(', ', $impl);
	}

    /**
     * @param string $content
     * @return mixed
     */
	private function parseContent(string $content){
		preg_match_all('/\(\((.*)\)\)/Us', $content, $matches, PREG_SET_ORDER);

		foreach($matches as $c){
			preg_match_all('/\[=(\w+)\]/', $c[1], $params, PREG_SET_ORDER);

			foreach($params as $p){
				$c[1] = str_replace($p[0], $this->dic_t->load('ShowVar')->parseFunction($p[1]), $c[1]);
			}

			$content = str_replace($c[0], 'echo \''.$c[1].'\';', $content);
		}

		return $content;
	}
}