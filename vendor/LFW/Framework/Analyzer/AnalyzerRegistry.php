<?php
	namespace LFW\Framework\Analyzer;
    use LFW\Framework\Globals\Server;

	class AnalyzerRegistry{
		private $config = [];
		private $request = [];
		private $route = '';
		private $session = [];

		public function getAllRegistry(): array{
			return [
				'config' => $this->config,
				'request' => $this->request,
				'route' => $this->route,
				'session' => $this->session
			];
		}

		public function getRoute(): string{
			return $this->route;
		}

		public function setConfigPHP(){
			$this->config['user'] = Server::getUser();
		}

		public function setRequest(string $request){
			$this->request[] = $request;
		}

		public function setRoute(string $route){
			$this->route = $route;
		}

		public function setSession(string $session){
			$this->session[] = $session;
		}
	}