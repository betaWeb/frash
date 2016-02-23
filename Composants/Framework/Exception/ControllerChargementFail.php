<?php
    namespace Composants\Framework\Exception;
    use Composants\Framework\Response\Response;
    use Composants\Framework\CreateLog\CreateErrorLog;

    /**
     * Class ControllerChargementFail
     * @package Composants\Framework\Exception
     */
    class ControllerChargementFail{
        /**
         * ControllerChargementFail constructor.
         * @param $controller
         */
        public function __construct($controller){
            new CreateErrorLog('Controller Not Found');
            return new Response('ControllerNotFound.html.twig', 'Exception', [ 'controller' => $controller ]);
        }
    }