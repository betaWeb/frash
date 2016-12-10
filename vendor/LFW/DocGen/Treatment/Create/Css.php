<?php
	namespace LFW\DocGen\Treatment\Create;
    use LFW\Framework\FileSystem\File;

	class Css{
		public static function work(){
			$code = "#corps{
	margin-top: 40px;
	padding-left: 10px;
	padding-right: 10px;
	padding-top:10px;
	padding-bottom: 100px;
	position:relative;
	overflow:hidden;
	background-color:#F5F5F5;
}

#summary{
	float:left;
    width:15%;
	height:100%;
	border-right:1px solid black;
	padding-top:2px;
	padding-left:4px;
	overflow:scroll;
	font-size:0.9em;
}

#contenu{
	float:left;
	margin-left:20px;
}";

			File::create('output/design.css', $code);
		}
	}