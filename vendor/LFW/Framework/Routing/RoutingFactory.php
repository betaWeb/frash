<?php
namespace LFW\Framework\Routing;
use LFW\Framework\DIC\Dic;
use LFW\Framework\FileSystem\Json;
use LFW\Framework\Routing\{ RouterJson, RouterPhp };

class RoutingFactory{
	private $conf;
	private $dic;

	public function __construct(Dic $dic)
	{
		$this->dic = $dic;
		$this->conf = Json::importConfig();
	}

	public function route(string $url)
	{
		if($this->conf['routing'] == 'json'){
			$router = new RouterJson($this->dic);
			return $router->routing($url, $this->conf);
		}
	}
}