<?php
	namespace LFW\Framework\Analyzer;
	use LFW\Framework\Analyzer\{ AnalyzerGeneration, AnalyzerRegistry };
    use LFW\Framework\DIC\Dic;
    use LFW\Framework\FileSystem\{ File, Json };
    use LFW\Framework\Globals\Server;

    /**
     * Class Analyzer
     * @package LFW\Framework\Analyzer
     */
	class Analyzer{
		/**
		 * @var Dic
		 */
		private $dic;

		/**
		 * @var AnalyzerRegistry
		 */
		private $registry;

		/**
         * Loader constructor.
		 * @param Dic $dic
		 */
		public function __construct(Dic $dic){
			$this->dic = $dic;
			$this->registry = new AnalyzerRegistry;
		}

		public function generation(){
			new AnalyzerGeneration($this->registry->getAllRegistry(), $this->registry->getRoute());
		}

		/**
		 * @return AnalyzerRegistry
		 */
		public function getRegistry(){
			return $this->registry;
		}

		/**
		 * @param string $route
		 * @param string $file
		 */
		public function display(string $route, string $file){
			$prefix = (string) $this->dic->load('get')->get('prefix');

			$port = Server::getServerPort();
			if($port == 80){
				$prefix_array = (string) 'http://'.Server::getServerName().$prefix.'Storage/Cache/Analyzer/'.$file.'.json';
			}
			else{
				$prefix_array = (string) 'http://'.Server::getServerName().':'.$port.$prefix.'Storage/Cache/Analyzer/'.$file.'.json';
			}

			$params = (array) array_merge([ 'true_route' => $route ], Json::decode(File::read($prefix_array)));
			return $this->dic->load('tel')->internal('Analyzer', 'vendor/LFW/Framework/Analyzer/display.tpl', $file, $params);
		}
	}