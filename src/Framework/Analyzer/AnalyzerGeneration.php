<?php
namespace Frash\Framework\Analyzer;
use Frash\Framework\FileSystem\{ Directory, File, Json };

/**
 * Class AnalyzerGeneration
 * @package Frash\Framework\Analyzer
 */
class AnalyzerGeneration{
	/**
     * AnalyzerGeneration constructor.
	 * @param array $registry
	 * @param string $route
	 */
	public function __construct(array $registry, string $route){
		if(!Directory::exist('Storage/Cache/Analyzer')){
        	Directory::create('Storage/Cache/Analyzer', 0770);
		}

		File::create('Storage/Cache/Analyzer/'.$route.'.json', Json::encode($registry));
	}
}