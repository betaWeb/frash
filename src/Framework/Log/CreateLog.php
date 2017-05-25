<?php
namespace Frash\Framework\Log;
use Frash\Framework\Request\Response;
use Frash\Framework\Request\Server\Server;

/**
 * Class CreateLog
 * @package Frash\Framework\Log
 */
class CreateLog{
	/**
	 * @param string $url
	 * @param array $conf
	 */
	public static function access(string $url, $conf){
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
	 * @param array $conf
	 */
	public static function error(string $error, $conf){
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
	 * @param array $conf
	 */
	public static function request(string $request, $conf){
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