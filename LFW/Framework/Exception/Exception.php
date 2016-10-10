<?php
    namespace LFW\Framework\Exception;
    use LFW\Framework\CreateLog\CreateErrorLog;

    /**
     * Class Exception
     * @package LFW\Framework\Exception
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