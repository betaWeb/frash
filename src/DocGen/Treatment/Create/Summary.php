<?php
namespace Frash\DocGen\Treatment\Create;

/**
 * Class Summary
 * @package Frash\DocGen\Treatment\Create
 */
class Summary{
	/**
	 * @param array $class
	 * @param string $prefix
	 * @return string
	 */
	public static function work(array $class, string $prefix): string{
		$code = (string) '';
        foreach($class as $c){
            $path = (string) str_replace('\\', '/', $c);
            $code .= '                  <a href="'.$prefix.'/Storage/output/src/'.$path.'.html">'.$path.'</a><br>'."\n";
        }

        return $code;
	}
}