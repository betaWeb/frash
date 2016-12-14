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
            $json = Json::importConfigArray();

            if($json['log']['error'] == 'yes'){
                $file = fopen('vendor/LFW/Logs/error.log', 'a');
                fwrite($file, date('d/m/Y à H:i:s').' - Error : '.$error."\n");
                fclose($file);
            }
        }
    }