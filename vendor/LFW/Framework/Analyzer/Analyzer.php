<?php
	namespace LFW\Framework\Analyzer;
	use LFW\Framework\Analyzer\{ AnalyzerGeneration, AnalyzerRegistry };
    use LFW\Framework\DIC\Dic;
    use LFW\Framework\FileSystem\Json;
    use LFW\Framework\Globals\Server;

	class Analyzer{
		private $dic;
		private $registry;
		private $route;

		public function __construct(Dic $dic){
			$this->dic = $dic;
			$this->registry = new AnalyzerRegistry;
		}

		public function generation(){
			new AnalyzerGeneration($this->registry->getAllRegistry(), $this->registry->getRoute());
		}

		public function getRegistry(){
			return $this->registry;
		}

		public function display(string $route, string $file){
			$prefix = $this->dic->load('get')->get('prefix');

			$port = Server::getServerPort();
			if($port == 80){
				$prefix_array = 'http://'.Server::getServerName().$prefix.'vendor/LFW/Cache/Analyzer/'.$file.'.json';
			}
			else{
				$prefix_array = 'http://'.Server::getServerName().':'.$port.$prefix.'vendor/LFW/Cache/Analyzer/'.$file.'.json';
			}

			$params = array_merge([ 'true_route' => $route ], Json::decode(file_get_contents($prefix_array)));
			return $this->dic->load('tel')->internal('Analyzer', 'vendor/LFW/Framework/Analyzer/display.tpl', $file, $params);
		}
	}