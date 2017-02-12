<?php
namespace LFW\Framework\Routing;
use LFW\Framework\DIC\Dic;
use LFW\Framework\FileSystem\InternalJson;
use LFW\Framework\Routing\{ RouterJson };

class RoutingFactory{
	private $conf;
	private $dic;

	public function __construct(Dic $dic)
	{
		$this->dic = $dic;
		$this->conf = InternalJson::importConfig();
	}

	public function route(string $url)
	{
		if($this->conf['routing'] == 'json'){
			$router = new RouterJson($this->dic);
			return $router->routing($url, $this->conf);
		}
	}
}