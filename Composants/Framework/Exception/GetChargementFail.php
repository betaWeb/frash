<?php
    namespace Composants\Framework\Exception;
    use Composants\Framework\CreateLog\CreateErrorLog;

    /**
     * Class GetChargementFail
     * @package Composants\Framework\Exception
     */
    class GetChargementFail{
        /**
         * GetChargementFail constructor.
         */
        public function __construct(){
            new CreateErrorLog('URL incorrecte');

            header('HTTP/1.0 404 Not Found', true, 404);
            die();
        }
    }