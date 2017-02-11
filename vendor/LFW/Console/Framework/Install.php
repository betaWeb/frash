<?php
namespace LFW\Console\Framework;
use LFW\Framework\FileSystem\File;

class Install
{
	public static function config($format_routing, $analyzer, $cache, $default_lang, $dispo_lang, $access_log, $error_log, $request_log){
		$array = [
			'env' => 'local',
			'routing' => $format_routing,
			'analyzer' => $analyzer,
			'racine' => [
				'path' => ''
			],
			'cache' => [
				'memcached' => [],
				'tpl' => $cache
			],
			'traduction' => [
				'default' => $default_lang,
				'available' => explode('/', $dispo_lang)
			],
			'log' => [
				'access' => $access_log,
				'error' => $error_log,
				'request' => $request_log
			]
		];

		File::create('Configuration/config.json', json_encode($array, JSON_PRETTY_PRINT));
	}

	public static function database($bundle){
		$array = [
			$bundle => [
				'host' => 'localhost',
				'username' => '',
				'password' => '',
				'dbname' => '',
				'system' => '',
				'port' => ''
			]
		];

		File::create('Configuration/database.json', json_encode($array, JSON_PRETTY_PRINT));
	}
}