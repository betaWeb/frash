<?php
	namespace LFW\DocGen\Treatment;
	use LFW\DocGen\Treatment\DirExist;

	class DirsClass{
		public static function work($class){
			foreach($class as $c){
                $expl = explode('/', str_replace('\\', '/', $c));
                $dir = 'output/src';
                $count = count($expl) - 1;

                for($i = 0; $i < $count; $i++){
                    DirExist::verif($dir.'/'.$expl[ $i ]);
                    $dir .= '/'.$expl[ $i ];
                }
            }
		}
	}