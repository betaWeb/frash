<?php
    namespace Composants\Framework\CreateLog;

    /**
     * Class CreateHTTPLog
     * @package Composants\Framework\CreateLog
     */
    class CreateHTTPLog{
        /**
         * CreateHTTPLog constructor.
         * @param $url
         */
        public function __construct($url){
            $file = fopen('Others/logs/access.log', 'a');
            fwrite($file, date('d/m/Y à H:i:s').' - IP : '.$_SERVER['REMOTE_ADDR'].' - '.$url."\n");
            fclose($file);
        }
    }