<?php
    namespace LFW\Framework\CreateLog;
    use LFW\Framework\Globals\Server;

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
            $json = json_decode(file_get_contents('vendor/LFW/Configuration/config.json'), true);

            if($json['log']['access'] == 'yes'){
                $file = fopen('vendor/LFW/Logs/access.log', 'a');
                fwrite($file, date('d/m/Y à H:i:s').' - IP : '.Server::getRemoteAddr().' - '.$url."\n");
                fclose($file);
            }
        }
    }