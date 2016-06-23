<?php
    namespace Composants\Framework\Exception;
    use Composants\Framework\Controller;
    use Composants\Framework\CreateLog\CreateErrorLog;

    /**
     * Class ControllerChargementFail
     * @package Composants\Framework\Exception
     */
    class ControllerChargementFail extends Controller{
        /**
         * ControllerChargementFail constructor.
         * @param $controller
         */
        public function __construct($controller){
            new CreateErrorLog('Controller '.$controller.' Not Found');

            return $this->view('ControllerNotFound.html.twig', 'Exception', [ 'controller' => $controller ]);
        }
    }