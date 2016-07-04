<?php
    namespace Composants\Framework\Exception;
    use Composants\Framework\CreateLog\CreateErrorLog;

    /**
     * Class RouteChargementFail
     * @package Composants\Framework\Exception
     */
    class RouteChargementFail{
        /**
         * RouteChargementFail constructor.
         * @param string $route
         */
        public function __construct($route){
            new CreateErrorLog('Route '.$route.' Not Found');

            header('HTTP/1.0 404 Not Found', true, 404);
            die();
        }
    }