<?php
    namespace LFW\Framework\CreateLog;
    use Symfony\Component\Yaml\Yaml;

    /**
     * Class CreateErrorLog
     * @package LFW\Framework\CreateLog
     */
    class CreateErrorLog{
        const CONFIG = 'LFW/Configuration/config.yml';
        const LOG = 'LFW/Logs/error.log';

        /**
         * CreateErrorLog constructor.
         * @param string $error
         */
        public function __construct($error){
            $yaml = Yaml::parse(file_get_contents(self::CONFIG));

            if($yaml['log']['error'] == 'yes'){
                $file = fopen(self::LOG, 'a');
                fwrite($file, date('d/m/Y à H:i:s').' - Error : '.$error."\n");
                fclose($file);
            }
        }
    }