<?php
namespace LFW\Framework\Log;
use LFW\Framework\FileSystem\Json;
use LFW\Framework\Globals\Server\Server;

/**
 * Class CreateLog
 * @package LFW\Framework\Log
 */
class CreateLog{
	/**
	 * @param string $url
	 */
	public static function access(string $url){
		if(Json::importConfig()['log']['access'] == 'yes'){
            $file = fopen('Storage/Logs/access.log', 'a');
            fwrite($file, date('d/m/Y à H:i:s').' - IP : '.Server::getRemoteAddr().' - '.$url."\n");
            fclose($file);
        }
	}

	/**
	 * @param string $error
	 */
	public static function error(string $error){
		if(Json::importConfig()['log']['error'] == 'yes'){
            $file = fopen('Storage/Logs/error.log', 'a');
            fwrite($file, date('d/m/Y à H:i:s').' - Error : '.$error."\n");
            fclose($file);
        }
	}

	/**
	 * @param string $request
	 */
	public static function request(string $request){
		if(Json::importConfig()['log']['request'] == 'yes'){
            $file = fopen('Storage/Logs/request.log', 'a');
            fwrite($file, date('d/m/Y à H:i:s').' - Request : '.$request."\n");
            fclose($file);
        }
	}
}