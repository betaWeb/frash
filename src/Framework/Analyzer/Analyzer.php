<?php
namespace Frash\Framework\Analyzer;
use Frash\Framework\Analyzer\{ AnalyzerGeneration, AnalyzerRegistry };
use Frash\Framework\DIC\Dic;
use Frash\Framework\FileSystem\{ File, Json };

/**
 * Class Analyzer
 * @package Frash\Framework\Analyzer
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
     * Analyzer constructor.
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
		$params = (array) array_merge([ 'true_route' => $route ], Json::decode(File::read('Storage/Cache/Analyzer/'.$file.'.json')));
		return $this->dic->load('tel')->internal('Analyzer', 'vendor/alixsperoza/frash/src/Framework/Analyzer/display.tpl', $file, $params);
	}
}