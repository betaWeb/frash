<?php
namespace Frash\Template\Cache;

/**
 * Class CreateClassCache
 * @package Frash\Template\Cache
 */
class CreateClassCache{
    /**
     * @param string $name_class
     * @return string
     */
	public static function create(string $name_class): string{
		$class_cache = '<?php'."\n";
		$class_cache .= 'namespace Storage\Cache\Templating;'."\n";
		$class_cache .= 'use Frash\Template\DependTemplEngine;'."\n";
		$class_cache .= 'use Frash\Template\Extensions\BottomBar\ImportBottomBar;'."\n\n";
		$class_cache .= 'class '.$name_class.'{'."\n";
		$class_cache .= '	private $bott_bar = \'\';'."\n";
		$class_cache .= '	private $dic_t;'."\n";
		$class_cache .= '	private $params = [];'."\n\n";
		$class_cache .= '	public function __construct($dic, DependTemplEngine $dic_t, $params = [], $env){'."\n";
		$class_cache .= '		$this->dic_t = $dic_t;'."\n";
		$class_cache .= '		$this->params = $params;'."\n\n";
		$class_cache .= '		if($env == \'local\'){'."\n";
		$class_cache .= '			$this->bott_bar = new ImportBottomBar($dic, $this->dic_t);'."\n";
		$class_cache .= '		}'."\n";
		$class_cache .= '	}'."\n\n";

		return $class_cache;
	}

    /**
     * @return string
     */
	public static function endClass(): string{
		return '}';
	}
}