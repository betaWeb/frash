<?php
    namespace Composants\Framework\Exception;
    use Composants\Framework\CreateLog\CreateErrorLog;

    /**
     * Class DeterminateFail
     * @package Composants\Framework\Exception
     */
    class DeterminateFail{
        /**
         * DeterminateFail constructor.
         * @param string $message
         */
        public function __construct($message){
            new CreateErrorLog($message, false);

            header('HTTP/1.0 404 Not Found', true, 404);
            die();
        }
    }