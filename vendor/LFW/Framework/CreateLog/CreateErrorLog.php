<?php
    namespace LFW\Framework\CreateLog;
    use LFW\Framework\FileSystem\Json;

    /**
     * Class CreateErrorLog
     * @package LFW\Framework\CreateLog
     */
    class CreateErrorLog{
        /**
         * CreateErrorLog constructor.
         * @param string $error
         */
        public function __construct(string $error){
            if(Json::importConfig()['log']['error'] == 'yes'){
                $file = fopen('Storage/Logs/error.log', 'a');
                fwrite($file, date('d/m/Y à H:i:s').' - Error : '.$error."\n");
                fclose($file);
            }
        }
    }