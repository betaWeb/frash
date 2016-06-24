<?php
    namespace Composants\Framework\CreateLog;
    use Composants\Framework\Globals\Server;
    use Composants\Yaml\Yaml;

    /**
     * Class CreateHTTPLog
     * @package Composants\Framework\CreateLog
     */
    class CreateHTTPLog{
        /**
         * CreateHTTPLog constructor.
         * @param string $url
         */
        public function __construct($url){
            $yaml = Yaml::parse(file_get_contents('Others/config/config.yml'));

            if($yaml['log']['access'] == 'yes'){
                $server = new Server;

                $file = fopen('Others/logs/access.log', 'a');
                fwrite($file, date('d/m/Y à H:i:s').' - IP : '.$server->getRemoteAddr().' - '.$url."\n");
                fclose($file);
            }
        }
    }