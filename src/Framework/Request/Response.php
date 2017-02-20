<?php
namespace Frash\Framework\Request;
use Frash\Framework\FileSystem\Json;

/**
 * Class Response
 * @package Frash\Framework\Request
 */
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