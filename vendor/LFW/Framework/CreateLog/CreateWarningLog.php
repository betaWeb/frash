<?php
    namespace LFW\Framework\CreateLog;
    use LFW\Framework\FileSystem\Json;

    /**
     * Class CreateWarningLog
     * @package LFW\Framework\CreateLog
     */
    class CreateWarningLog{
        /**
         * CreateWarningLog constructor.
         * @param string $warning
         */
        public function __construct(string $warning){
            $json = Json::importConfigArray();

            if($json['log']['warning'] == 'yes'){
                $file = fopen('vendor/LFW/Logs/warning.log', 'a');
                fwrite($file, date('d/m/Y à H:i:s').' - Warning : '.$warning."\n");
                fclose($file);
            }
        }
    }