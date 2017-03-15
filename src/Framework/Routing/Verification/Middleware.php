<?php
namespace Frash\Framework\Routing\Verification;
use Frash\Framework\DIC\Dic;

/**
 * Class Middleware
 * @package Frash\Framework\Routing\Verification
 */
class Middleware{
	/**
	 * @param Dic $dic
	 * @param array $middlewares
	 * @return bool|Exception
	 */
	public static function define(Dic $dic, $middlewares){
		if(empty($middlewares) || count($middlewares) == 0){
			return true;
		} else {
			$service = $dic->get('conf')['service']['middleware'];

			foreach($middlewares as $midw){
				if(!strstr($service[ $midw ], '@')){
					throw new \Exception('Missing bundle before middleware '.$midw);
				} else {
					list($bundle, $middleware) = explode('@', $service[ $midw ]);
					$path = 'Bundles\\'.$bundle.'\Service\\'.$middleware;

					if(class_exists($path)){
						$class = new $path($dic);
						return $class->define();
					} else {
						throw new \Exception('Middleware '.$middleware.' not found');
					}
				}
			}
		}
	}
}