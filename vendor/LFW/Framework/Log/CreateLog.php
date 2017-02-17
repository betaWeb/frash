<?php
namespace LFW\Framework\Log;
use LFW\Framework\FileSystem\InternalJson;
use LFW\Framework\Request\Response;
use LFW\Framework\Request\Server\Server;

/**
 * Class CreateLog
 * @package LFW\Framework\Log
 */
class CreateLog{
	/**
	 * @param string $url
	 */
	public static function access(string $url){
		$conf = InternalJson::importConfig()['log'];

		if(Response::xmlHttpRequest()){
			if($conf['ajax'] == 'yes' && $conf['access'] == 'yes'){
				$file = fopen('Storage/Logs/access.log', 'a');
	            fwrite($file, date('d/m/Y à H:i:s').' - IP : '.Server::remoteAddr().' - '.$url."\n");
	            fclose($file);
			}
		} else {
			if($conf['access'] == 'yes'){
	            $file = fopen('Storage/Logs/access.log', 'a');
	            fwrite($file, date('d/m/Y à H:i:s').' - IP : '.Server::remoteAddr().' - '.$url."\n");
	            fclose($file);
	        }
		}
	}

	/**
	 * @param string $error
	 */
	public static function error(string $error){
		$conf = InternalJson::importConfig()['log'];

		if(Response::xmlHttpRequest()){
			if($conf['ajax'] == 'yes' && $conf['error'] == 'yes'){
				$file = fopen('Storage/Logs/error.log', 'a');
	            fwrite($file, date('d/m/Y à H:i:s').' - Error : '.$error."\n");
	            fclose($file);
			}
		} else {
			if($conf['error'] == 'yes'){
	            $file = fopen('Storage/Logs/error.log', 'a');
	            fwrite($file, date('d/m/Y à H:i:s').' - Error : '.$error."\n");
	            fclose($file);
	        }
	    }
	}

	/**
	 * @param string $request
	 */
	public static function request(string $request){
		$conf = InternalJson::importConfig()['log'];

		if(Response::xmlHttpRequest()){
			if($conf['ajax'] == 'yes' && $conf['request'] == 'yes'){
				$file = fopen('Storage/Logs/request.log', 'a');
	            fwrite($file, date('d/m/Y à H:i:s').' - Request : '.$request."\n");
	            fclose($file);
			}
		} else {
			if($conf['request'] == 'yes'){
	            $file = fopen('Storage/Logs/request.log', 'a');
	            fwrite($file, date('d/m/Y à H:i:s').' - Request : '.$request."\n");
	            fclose($file);
	        }
	    }
	}
}