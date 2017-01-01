<?php
	namespace LFW\Framework\Analyzer;
	use LFW\Framework\Analyzer\AnalyzerGeneration;
	use LFW\Framework\Analyzer\AnalyzerRegistry;
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
			new AnalyzerGeneration($this->registry->getAllRegistry(), $this->route);
		}

		public function getRegistry(){
			return $this->registry;
		}

		public function setRoute(string $route){
			$this->route = $route;
		}

		public function display(string $file){
			$prefix = $this->dic->load('get')->get('prefix');
			$prefix_array = 'http://'.Server::getServerName().$prefix.'vendor/LFW/Cache/Analyzer/'.$file.'.json';

			return $this->dic->load('tel')->internal('Analyzer', 'vendor/LFW/Framework/Analyzer/display.tpl', $file, Json::decode(file_get_contents($prefix_array)));
		}
	}