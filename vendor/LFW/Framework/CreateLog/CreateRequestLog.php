<?php
    namespace LFW\Framework\CreateLog;

    /**
     * Class CreateRequestLog
     * @package LFW\Framework\CreateLog
     */
    class CreateRequestLog{
        /**
         * CreateRequestLog constructor.
         * @param string $request
         */
        public function __construct($request){
            $json = json_decode(file_get_contents('Configuration/config.json'), true);

            if($json['log']['request'] == 'yes'){
                $file = fopen('vendor/LFW/Logs/request.log', 'a');
                fwrite($file, date('d/m/Y à H:i:s').' - Request : '.$request."\n");
                fclose($file);
            }
        }
    }