<?php
    namespace LFW\Framework\CreateLog;

    /**
     * Class CreateErrorLog
     * @package LFW\Framework\CreateLog
     */
    class CreateErrorLog{
        /**
         * CreateErrorLog constructor.
         * @param string $error
         */
        public function __construct($error){
            $json = json_decode(file_get_contents('vendor/LFW/Configuration/config.json'), true);

            if($json['log']['error'] == 'yes'){
                $file = fopen('vendor/LFW/Logs/error.log', 'a');
                fwrite($file, date('d/m/Y à H:i:s').' - Error : '.$error."\n");
                fclose($file);
            }
        }
    }