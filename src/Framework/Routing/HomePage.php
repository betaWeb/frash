<?php
namespace Frash\Framework\Routing;
use Frash\Framework\DIC\Dic;

/**
 * Class HomePage
 * @package Frash\Framework\Routing
 */
class HomePage{
	/**
	 * @var Dic
	 */
	private $dic;

    /**
     * HomePage constructor.
     * @param Dic $dic
     */
	public function __construct(Dic $dic){
		$this->dic = $dic;
	}

	public function show(){
		return $this->dic->load('tpl')->internal('HomePage', 'vendor/alixsperoza/frash/ressources/views/homepage.tpl');
	}
}