<?php
	namespace LFW\Framework\Analyzer;
    use LFW\Framework\FileSystem\{ Directory, File, Json };

	class AnalyzerGeneration{
		public function __construct(array $registry, string $route){
			if(Directory::exist('vendor/LFW/Cache/Analyzer') === false){
            	Directory::create('vendor/LFW/Cache/Analyzer', 0775);
			}

			File::create('vendor/LFW/Cache/Analyzer/'.$route.'.json', Json::encode($registry));
		}
	}