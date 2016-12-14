<?php
    namespace LFW\Framework\CreateLog;
    use LFW\Framework\FileSystem\Json;

    /**
     * Class CreateRequestLog
     * @package LFW\Framework\CreateLog
     */
    class CreateRequestLog{
        /**
         * CreateRequestLog constructor.
         * @param string $request
         */
        public function __construct(string $request){
            $json = Json::importConfigArray();

            if($json['log']['request'] == 'yes'){
                $file = fopen('vendor/LFW/Logs/request.log', 'a');
                fwrite($file, date('d/m/Y à H:i:s').' - Request : '.$request."\n");
                fclose($file);
            }
        }
    }