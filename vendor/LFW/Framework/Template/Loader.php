<?php
	namespace LFW\Framework\Template;
    use LFW\Framework\DIC\Dic;
    use LFW\Framework\Exception\Exception;
    use LFW\Framework\FileSystem\Directory;
    use LFW\Framework\FileSystem\File;
	use LFW\Framework\Template\Parser;

    /**
     * Class Loader
     * @package LFW\Framework\Template
     */
	class Loader{
        /**
         * @var string
         */
        private $bundle = '';

        /**
         * @var Dic
         */
        private $dic;

        /**
         * @var string
         */
        private $file = '';

        /**
         * @var array
         */
        private $params = [];

        /**
         * Loader constructor.
         * @param string $file
         * @param array $params
         * @param Dic $dic
         */
		public function __construct($file, $params, Dic $dic){
			$this->bundle = $dic->open('get')->get('bundle');
			$this->dic = $dic;
			$this->file = $file;
			$this->params = $params;
		}

		public function view(){
			if(File::exist('Bundles/'.$this->bundle.'/Views/'.$this->file) === false){
                return new Exception('Template '.$this->file.' not found.');
            }

            if(Directory::exist('vendor/LFW/Cache/Templating') === false){
            	Directory::create('vendor/LFW/Cache/Templating', 0775);
			}

            $parser = new Parser('Bundles/'.$this->bundle.'/Views/'.$this->file, $this->params, $this->dic);
            $parser->parse();
		}
	}