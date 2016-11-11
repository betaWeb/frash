<?php
	namespace LFW\Framework\Templating;
    use LFW\Framework\Exception\Exception;
	use LFW\Framework\Templating\Parser;

	class Loader{
        private $bundle = '';
        private $cache = '';
        private $file = '';
        private $lang = '';
        private $list = [];
        private $nurl = [];
        private $params = [];

		public function __construct($file, $list){
			$this->file = $file;
			$this->bundle = $list['bundle'];
			$this->list = $list;
		}

		public function view(){
			if(!file_exists('Bundles/'.$this->bundle.'/Views/'.$this->file)){
                return new Exception('Template '.$this->file.' not found.');
            }

            $parser = new Parser('Bundles/'.$this->bundle.'/Views/'.$this->file, $this->list);
            $parser->parse();
		}
	}