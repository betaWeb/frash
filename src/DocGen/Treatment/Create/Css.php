<?php
namespace Frash\DocGen\Treatment\Create;
use Frash\Framework\FileSystem\File;

/**
 * Class Css
 * @package Frash\DocGen\Treatment\Create
 */
class Css{
	public static function work(){
		$code = (string) "#corps{
	margin-top:40px;
	padding-left:10px;
	padding-right:10px;
	padding-top:10px;
	padding-bottom:100px;
	position:relative;
	overflow:hidden;
	background-color:#F5F5F5;
}

a{
	text-decoration:none;
}

a:visited{
	color:blue;
}

#summary{
	float:left;
    width:15%;
	height:100%;
	border-right:1px solid black;
	padding-top:2px;
	padding-left:4px;
	overflow:scroll;
}

#contenu{
	float:left;
	margin-left:20px;
}

.div_object{
	float:left;
	margin-left:20px;
}";

		File::create('Storage/output/design.css', $code);
	}
}