<?php
namespace Frash\Framework\DIC;
use Frash\Framework\DIC\Dic;
use Frash\Framework\Request\Server\Server;

/**
 * Class Navigator
 * @package Frash\Framework\DIC
 */
class Navigator{
	/**
	 * @param Dic $dic
	 * @param string $stock_route
	 * @return array
	 */
	public static function define(Dic $dic, $stock_route){
		$session = $dic->load('session');

		if(!empty($stock_route) && $stock_route == 'yes'){
            if($session->has('frash_current_url')){
                $session->set('frash_before_url', $session->get('frash_current_url'));
                $session->set('frash_current_url', Server::requestUri());
            }
		}

		return $session->list_flashbag();
	}
}