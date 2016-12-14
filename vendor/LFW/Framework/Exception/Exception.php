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
        public function __construct(string $message){
            new CreateErrorLog($message);

            ob_start();
            debug_print_backtrace();
            $data = ob_get_clean();

            echo '<pre>'; print_r($data); echo '</pre>';

            header('HTTP/1.0 404 Not Found', true, 404);
            die();
        }
    }