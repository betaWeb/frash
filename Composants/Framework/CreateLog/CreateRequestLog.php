<?php
    namespace Composants\Framework\CreateLog;
    use Composants\Yaml\Yaml;

    /**
     * Class CreateRequestLog
     * @package Composants\Framework\CreateLog
     */
    class CreateRequestLog{
        /**
         * CreateRequestLog constructor.
         * @param string $request
         */
        public function __construct($request){
            $yaml = Yaml::parse(file_get_contents('Composants/Configuration/config.yml'));

            if($yaml['log']['request'] == 'yes'){
                $file = fopen('Composants/Logs/request.log', 'a');
                fwrite($file, date('d/m/Y à H:i:s').' - Request : '.$request."\n");
                fclose($file);
            }
        }
    }