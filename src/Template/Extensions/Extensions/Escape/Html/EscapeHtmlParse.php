<?php
namespace Frash\Template\Extensions\Extensions\Escape\Html;
use Frash\Template\DependTemplEngine;
use Frash\Template\Extensions\Extend\ExtensionParseSimple;

/**
 * Class EscapeHtmlParse
 * @package Frash\Template\Extensions\Extensions\Escape\Html
 */
class EscapeHtmlParse extends ExtensionParseSimple{
    public function open(){}

    public function close(){
		preg_match('/\{\{ esc_html \}\}(.*)\{\{ end_esc_html \}\}/s', $this->infos['tpl'], $match);
		$this->infos['tpl'] = str_replace($match[0], htmlentities($match[1]), $this->infos['tpl']);
    }
}