<?php
	namespace LFW\Framework\Analyzer;
    use LFW\Framework\Globals\Server;

	class AnalyzerRegistry{
		private $config = [];
		private $request = [];
		private $session = [];

		public function getAllRegistry(): array{
			return [
				'config' => $this->config,
				'request' => $this->request,
				'session' => $this->session
			];
		}

		public function setConfigPHP(){
			$this->config['user'] = Server::getUser();
		}

		public function setRequest(string $request){
			$this->request[] = $request;
		}

		public function setSession(string $session){
			$this->session[] = $session;
		}
	}