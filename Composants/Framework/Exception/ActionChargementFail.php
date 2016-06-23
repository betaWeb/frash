<?php
    namespace Composants\Framework\Exception;
    use Composants\Framework\Controller;
    use Composants\Framework\CreateLog\CreateErrorLog;

    /**
     * Class ActionChargementFail
     * @package Composants\Framework\Exception
     */
    class ActionChargementFail extends Controller{
        /**
         * ActionChargementFail constructor.
         * @param string $action
         */
        public function __construct($action){
            new CreateErrorLog('Action '.$action.' Not Found');

            return $this->view('ActionNotFound.html.twig', 'Exception', [ 'action' => $action ]);
        }
    }