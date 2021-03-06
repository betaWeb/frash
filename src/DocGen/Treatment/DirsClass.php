<?php
namespace Frash\DocGen\Treatment;
use Frash\DocGen\Treatment\DirExist;

/**
 * Class DirsClass
 * @package Frash\DocGen\Treatment
 */
class DirsClass{
    /**
     * @param array $class
     */
	public static function work(array $class){
		foreach($class as $c){
            $expl = (array) explode('/', str_replace('\\', '/', $c));
            $dir = (string) 'Storage/output/src';
            $count = (int) count($expl) - 1;

            for($i = 0; $i < $count; $i++){
                DirExist::verif($dir.'/'.$expl[ $i ]);
                $dir .= '/'.$expl[ $i ];
            }
        }
	}
}