<?php
    namespace LFW\Framework\CreateLog;
    use Symfony\Component\Yaml\Yaml;

    /**
     * Class CreateRequestLog
     * @package LFW\Framework\CreateLog
     */
    class CreateRequestLog{
        const CONFIG = 'Composants/Configuration/config.yml';
        const LOG = 'Composants/Logs/request.log';

        /**
         * CreateRequestLog constructor.
         * @param string $request
         */
        public function __construct($request){
            $yaml = Yaml::parse(file_get_contents(self::CONFIG));

            if($yaml['log']['request'] == 'yes'){
                $file = fopen(self::LOG, 'a');
                fwrite($file, date('d/m/Y à H:i:s').' - Request : '.$request."\n");
                fclose($file);
            }
        }
    }