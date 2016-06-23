<?php
    namespace Composants\Framework\CreateLog;
    use Composants\Yaml\Yaml;

    /**
     * Class CreateErrorLog
     * @package Composants\Framework\CreateLog
     */
    class CreateErrorLog{
        /**
         * CreateErrorLog constructor.
         * @param string $error
         */
        public function __construct($error){
            $yaml = Yaml::parse(file_get_contents('Others/config/config.yml'));

            if($yaml['log']['error'] == 'yes'){
                $file = fopen('Others/logs/error.log', 'a');
                fwrite($file, date('d/m/Y à H:i:s').' - Error : '.$error."\n");
                fclose($file);
            }
        }
    }