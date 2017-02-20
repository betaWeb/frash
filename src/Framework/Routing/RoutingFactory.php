<?php
namespace Frash\Framework\Routing;
use Frash\Framework\Log\CreateLog;
use Frash\Framework\DIC\Dic;
use Frash\Framework\Routing\{ RouterJson, RouterPhp };

class RoutingFactory{
	private $conf;
	private $dic;

	public function __construct(Dic $dic)
	{
		$this->dic = $dic;
		$this->conf = $this->dic->get('conf')['config'];
	}

	public function route(string $url)
	{
		CreateLog::access($url, $this->conf['log']);

        $this->dic->set('uri', $url);
        $this->dic->set('cache_tpl', $this->conf['cache']['tpl']);
        $this->dic->set('env', $this->conf['env']);
        $this->dic->set('analyzer', $this->conf['analyzer']);

		if($this->conf['routing'] == 'json'){
			$router = new RouterJson($this->dic);
			return $router->routing($url, $this->conf);
		} elseif($this->conf['routing'] == 'php') {
			$router = new RouterPhp($this->dic);
			return $router->routing($url, $this->conf);
		}
	}
}