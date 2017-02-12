<?php
namespace LFW\Framework\Request;
use LFW\Framework\FileSystem\Json;

class Response{
	/**
	 * @param string|array
	 */
	public static function Json($value){
		echo Json::encode($value);
	}

	/**
	 * @return bool
	 */
	public static function xmlHttpRequest(): bool{
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'){
			return true;
		} else {
			return false;
		}
	}
}