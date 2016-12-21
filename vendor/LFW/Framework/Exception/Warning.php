<?php
    namespace LFW\Framework\Exception;
    use LFW\Framework\CreateLog\CreateWarningLog;

    /**
     * Class Warning
     * @package LFW\Framework\Exception
     */
    class Warning{
        /**
         * Warning constructor.
         * @param string $message
         */
        public function __construct(string $message){
            new CreateWarningLog($message);
        }
    }