<?php
    namespace Composants\Framework\CreateLog;

    /**
     * Class CreateRequestLog
     * @package Composants\Framework\CreateLog
     */
    class CreateRequestLog{
        /**
         * CreateRequestLog constructor.
         * @param $request
         */
        public function __construct($request){
            $file = fopen('Others/logs/request.log', 'a');
            $string = date('d/m/Y à H:i:s').' - Request : '.$request."\n";
            fwrite($file, $string);
            fclose($file);
        }
    }