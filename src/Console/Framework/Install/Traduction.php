<?php
namespace Frash\Console\Framework\Install;
use Frash\Framework\FileSystem\File;

/**
 * Class Traduction
 * @package Frash\Console\Framework\Install
 */
class Traduction{
	/**
	 * @param string $langs
	 */
	public static function create(string $langs){
		$expl = explode('/', $langs);

		foreach($expl as $lang){
			$code = '<?php'."\n";
			$code .= 'namespace Traductions;'."\n";
			$code .= 'use Frash\Framework\TraductionParent;'."\n\n";
			$code .= 'class Trad'.ucfirst($lang).' extends TraductionParent{}';

			File::create('Traductions/Trad'.ucfirst($lang).'.php', $code);
		}
	}
}