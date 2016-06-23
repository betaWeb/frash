<?php
    namespace Composants\Framework\Exception;
    use Composants\Framework\Controller;
    use Composants\Framework\CreateLog\CreateErrorLog;

    /**
     * Class RouteChargementFail
     * @package Composants\Framework\Exception
     */
    class RouteChargementFail extends Controller{
        /**
         * RouteChargementFail constructor.
         * @param string $route
         */
        public function __construct($route){
            new CreateErrorLog('Route '.$route.' Not Found');

            return $this->view('RouteNotFound.html.twig', 'Exception', [ 'route' => $route ]);
        }
    }