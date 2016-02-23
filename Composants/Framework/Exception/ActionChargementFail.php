<?php
    namespace Composants\Framework\Exception;
    use Composants\Framework\Response\Response;
    use Composants\Framework\CreateLog\CreateErrorLog;

    /**
     * Class ActionChargementFail
     * @package Composants\Framework\Exception
     */
    class ActionChargementFail{
        /**
         * ActionChargementFail constructor.
         * @param $action
         */
        public function __construct($action){
            new CreateErrorLog('Action Not Found');
            return new Response('ActionNotFound.html.twig', 'Exception', [ 'action' => $action ]);
        }
    }