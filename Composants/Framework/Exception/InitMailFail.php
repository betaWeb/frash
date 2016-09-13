<?php
    namespace Composants\Framework\Exception;
    use Composants\Framework\CreateLog\CreateErrorLog;

    /**
     * Class InitMailFail
     * @package Composants\Framework\Exception
     */
    class InitMailFail{
        /**
         * InitMailFail constructor.
         */
        public function __construct($message){
            new CreateErrorLog($message, false);

            header('HTTP/1.0 404 Not Found', true, 404);
            die();
        }
    }