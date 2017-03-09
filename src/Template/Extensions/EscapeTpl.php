<?php
namespace Frash\Template\Extensions;
use Frash\Template\Extensions\Extension;

/**
 * Class EscapeTpl
 * @package Frash\Template\Extensions
 */
class EscapeTpl extends Extension{
	public function open(){
		$this->infos['level']['escape_tpl']++;
	}

	public function close(){
		$this->infos['level']['escape_tpl']--;

		preg_match('/\[escape_tpl\](.*)\[\/escape_tpl\]/Us', $this->infos['tpl'], $match);
		$this->infos['tpl'] = str_replace($match[0], $match[1], $this->infos['tpl']);
	}
}