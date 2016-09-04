<?php
    namespace Composants\Framework\CreateLog;
    use Composants\Yaml\Yaml;

    /**
     * Class CreateRequestLog
     * @package Composants\Framework\CreateLog
     */
    class CreateRequestLog{
        const CONFIG = 'Composants/Configuration/config.yml';
        const LOG = 'Composants/Logs/request.log';

        /**
         * CreateRequestLog constructor.
         * @param string $request
         */
        public function __construct($request, $ajax){
            $yaml = ($ajax === false) ? Yaml::parse(file_get_contents(self::CONFIG)) : Yaml::parse(file_get_contents('../../../'.self::CONFIG));

            if($yaml['log']['request'] == 'yes'){
                $file = ($ajax === false) ? fopen(self::LOG, 'a') : fopen('../../../'.self::LOG, 'a');
                fwrite($file, date('d/m/Y à H:i:s').' - Request : '.$request."\n");
                fclose($file);
            }
        }
    }