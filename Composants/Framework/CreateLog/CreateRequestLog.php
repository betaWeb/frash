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
            $yaml = Yaml::parse(file_get_contents('Others/config/config.yml'));

            if($yaml['log']['request'] == 'yes'){
                $file = fopen('Others/logs/request.log', 'a');
                fwrite($file, date('d/m/Y à H:i:s').' - Request : '.$request."\n");
                fclose($file);
            }
        }
    }