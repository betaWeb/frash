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
            if(Json::importConfig()['log']['warning'] == 'yes'){
                $file = fopen('Storage/Logs/warning.log', 'a');
                fwrite($file, date('d/m/Y à H:i:s').' - Warning : '.$warning."\n");
                fclose($file);
            }
        }
    }