<?php
    namespace Composants\Framework\Exception;
    use Composants\Framework\CreateLog\CreateErrorLog;

    /**
     * Class Exception
     * @package Composants\Framework\Exception
     */
    class Exception{
        /**
         * Exception constructor.
         * @param string $message
         */
        public function __construct($message){
            new CreateErrorLog($message);

            header('HTTP/1.0 404 Not Found', true, 404);
            die();
        }
    }