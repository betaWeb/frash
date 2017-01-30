<?php
namespace LFW\Framework\Response;
use LFW\Framework\FileSystem\Json;

class Response{
	public static function Json($value){
		echo Json::encode($value);
	}
}