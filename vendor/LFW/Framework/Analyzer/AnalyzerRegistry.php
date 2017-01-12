<?php
	namespace LFW\Framework\Analyzer;
    use LFW\Framework\Globals\Server;

    /**
     * Class AnalyzerRegistry
     * @package LFW\Framework\Analyzer
     */
	class AnalyzerRegistry{
		/**
		 * @var array
		 */
		private $config = [];

		/**
		 * @var array
		 */
		private $request = [];

		/**
		 * @var string
		 */
		private $route = '';

		/**
		 * @var array
		 */
		private $session = [];

		/**
		 * @return array
		 */
		public function getAllRegistry(): array{
			return [
				'config' => $this->config,
				'request' => $this->request,
				'route' => $this->route,
				'session' => $this->session
			];
		}

		/**
		 * @return string
		 */
		public function getRoute(): string{
			return $this->route;
		}

		public function setConfigPHP(){
			$this->config['user'] = Server::getUser();
		}

		/**
		 * @param string $request
		 */
		public function setRequest(string $request){
			$this->request[] = $request;
		}

		/**
		 * @param string $route
		 */
		public function setRoute(string $route){
			$this->route = $route;
		}

		/**
		 * @param string $session
		 */
		public function setSession(string $session){
			$this->session[] = $session;
		}
	}