<?php
    namespace LFW\Framework\CreateLog;
    use LFW\Framework\Globals\Server;
    use Symfony\Component\Yaml\Yaml;

    /**
     * Class CreateHTTPLog
     * @package LFW\Framework\CreateLog
     */
    class CreateHTTPLog{
        /**
         * CreateHTTPLog constructor.
         * @param string $url
         */
        public function __construct($url){
            $yaml = Yaml::parse(file_get_contents('LFW/Configuration/config.yml'));

            if($yaml['log']['access'] == 'yes'){
                $server = new Server;

                $file = fopen('LFW/Logs/access.log', 'a');
                fwrite($file, date('d/m/Y à H:i:s').' - IP : '.$server->getRemoteAddr().' - '.$url."\n");
                fclose($file);
            }
        }
    }