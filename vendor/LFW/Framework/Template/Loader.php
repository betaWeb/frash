<?php
	namespace LFW\Framework\Template;
    use LFW\Framework\Exception\Exception;
    use LFW\Framework\FileSystem\Directory;
    use LFW\Framework\FileSystem\File;
	use LFW\Framework\Template\Parser;

	class Loader{
        private $bundle = '';
        private $dic;
        private $file = '';
        private $params = [];

		public function __construct($file, $params, $dic){
			$this->bundle = $dic->open('get')->get('bundle');
			$this->dic = $dic;
			$this->file = $file;
			$this->params = $params;
		}

		public function view(){
			if(File::exist('Bundles/'.$this->bundle.'/Views/'.$this->file) === false){
                return new Exception('Template '.$this->file.' not found.');
            }

            if(File::exist('vendor/LFW/Cache/Templating') === false){
            	Directory::create('vendor/LFW/Cache/Templating', 0775);
			}

            $parser = new Parser('Bundles/'.$this->bundle.'/Views/'.$this->file, $this->params, $this->dic);
            $parser->parse();
		}
	}