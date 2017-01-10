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
            if(Json::importConfig()['log']['request'] == 'yes'){
                $file = fopen('Storage/Logs/request.log', 'a');
                fwrite($file, date('d/m/Y à H:i:s').' - Request : '.$request."\n");
                fclose($file);
            }
        }
    }