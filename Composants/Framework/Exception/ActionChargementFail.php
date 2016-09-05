<?php
    namespace Composants\Framework\Exception;
    use Composants\Framework\CreateLog\CreateErrorLog;

    /**
     * Class ActionChargementFail
     * @package Composants\Framework\Exception
     */
    class ActionChargementFail{
        /**
         * ActionChargementFail constructor.
         * @param string $action
         */
        public function __construct($action){
            new CreateErrorLog('Action '.$action.' Not Found', false);

            header('HTTP/1.0 404 Not Found', true, 404);
            die();
        }
    }