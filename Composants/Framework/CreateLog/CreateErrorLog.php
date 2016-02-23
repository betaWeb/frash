<?php
    namespace Composants\Framework\CreateLog;

    /**
     * Class CreateErrorLog
     * @package Composants\Framework\CreateLog
     */
    class CreateErrorLog{
        /**
         * CreateErrorLog constructor.
         * @param $error
         */
        public function __construct($error){
            $file = fopen('Others/logs/error.log', 'a');
            $string = date('d/m/Y à H:i:s').' - Error : '.$error."\n";
            fwrite($file, $string);
            fclose($file);
        }
    }