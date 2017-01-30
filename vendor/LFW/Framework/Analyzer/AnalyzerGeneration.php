<?php
namespace LFW\Framework\Analyzer;
use LFW\Framework\FileSystem\{ Directory, File, Json };

/**
 * Class AnalyzerGeneration
 * @package LFW\Framework\Analyzer
 */
class AnalyzerGeneration{
	/**
     * Loader constructor.
	 * @param array $registry
	 * @param string $route
	 */
	public function __construct(array $registry, string $route){
		if(Directory::exist('Storage/Cache/Analyzer') === false){
        	Directory::create('Storage/Cache/Analyzer', 0770);
		}

		File::create('Storage/Cache/Analyzer/'.$route.'.json', Json::encode($registry));
	}
}