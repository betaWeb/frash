<?php
	namespace LFW\Framework\Template;
    use LFW\Framework\DIC\Dic;
    use LFW\Framework\Exception\Exception;
    use LFW\Framework\FileSystem\{ Directory, File, Json };
    use LFW\Framework\Template\{ DependTemplEngine, Parser };

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
         * @var DependTemplEngine
         */
        private $dic_t;

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
            $this->dic = $dic;
            $gets = $this->dic->load('get');

			$this->bundle = $gets->get('bundle');
            $this->env = $gets->get('env');
			$this->file = $file;
			$this->params = $params;

            $this->dic_t = new DependTemplEngine;
            $this->dic_t->setParams('json', Json::importConfigArray());
            $this->dic_t->setParams('nurl', explode('/', $gets->get('uri')));
            $this->dic_t->setParams('params', $this->params);
		}

		public function view(){
			if(File::exist('Bundles/'.$this->bundle.'/Views/'.$this->file) === false){
                return new Exception('Template '.$this->file.' not found.');
            }

            if(Directory::exist('vendor/LFW/Cache/Templating') === false){
            	Directory::create('vendor/LFW/Cache/Templating', 0775);
			}

            $name_file = 'TemplateOf'.md5('Bundles/'.$this->bundle.'/Views/'.$this->file);
            if(File::exist('vendor/LFW/Cache/Templating/'.$name_file.'.php') === false){
                $path_tpl = 'Bundles/'.$this->bundle.'/Views/'.$this->file;

                $parser = new Parser($path_tpl, $this->params, $this->dic, $this->dic_t, $name_file);
                $parser->parse();
            }

            $path_class = 'LFW\Cache\Templating\\'.$name_file;
            $tpl_class = new $path_class($this->dic, $this->dic_t, $this->params, $this->env);
            echo $tpl_class->display();
		}
	}