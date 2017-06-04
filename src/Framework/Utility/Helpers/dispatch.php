<?php
use Frash\Framework\FileSystem\File;

function defineDispatcher()
{
	$class = 'Frash\Framework\Dispatch\Dispatcher';

	if($file = File::read('dispatch.json')){
		$json = json_decode($file, true);

		if(!empty($json['class'])){
			$class = $json['class'];
		}
	}

	return $class;
}