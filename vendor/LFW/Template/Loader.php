<?php
	namespace LFW\Template;
    use LFW\Framework\DIC\Dic;
    use LFW\Framework\Exception\Exception;
    use LFW\Framework\FileSystem\{ Directory, File, Json };
    use LFW\Template\{ DependTemplEngine, Parser };

    /**
     * Class Loader
     * @package LFW\Template
     */
	class Loader{
        /**
         * @var string
         */
        private $bundle = '';

        /**
         * @var string
         */
        private $cache = '';

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
		public function __construct(string $file, array $params, Dic $dic){
            $this->dic = $dic;
            $gets = $this->dic->load('get');

			$this->bundle = $gets->get('bundle');
            $this->cache = $gets->get('cache_tpl');
            $this->env = $gets->get('env');
			$this->file = $file;
			$this->params = $params;

            $this->dic_t = new DependTemplEngine;
            $this->dic_t->setParams('json', Json::importConfigArray());
            $this->dic_t->setParams('nurl', explode('/', $gets->get('uri')));
            $this->dic_t->setParams('params', $this->params);
            $this->dic_t->setParams('prefix', $gets->get('prefix'));
            $this->dic_t->setParams('prefix_lang', $gets->get('prefix_lang'));
		}

		public function view(){
            $this->dirTemplatingExist();

            if(File::exist('Bundles/'.$this->bundle.'/Views/'.$this->file) === false){
                return new Exception('Template '.$this->file.' not found.');
            }

            $name_file = 'TemplateOf'.md5('Bundles/'.$this->bundle.'/Views/'.$this->file);
            if(File::exist('vendor/LFW/Cache/Templating/'.$name_file.'.php') === false){
                $parser = new Parser('Bundles/'.$this->bundle.'/Views/'.$this->file, $this->params, $this->dic, $this->dic_t, $name_file);
                $parser->parse();
            }

            $path_class = 'LFW\Cache\Templating\\'.$name_file;
            $tpl_class = new $path_class($this->dic, $this->dic_t, $this->params, $this->env);
            echo $tpl_class->display();

            $this->ifNoCache($name_file);
		}

        public function internal(string $type, string $file){
            $this->dirTemplatingExist();

            $name_file = 'Display'.$type;
            if(File::exist('vendor/LFW/Cache/Templating/Display.php') === false){
                $parser = new Parser($this->file, $this->params, $this->dic, $this->dic_t, $name_file);
                $parser->parse($type);
            }

            $path_class = 'LFW\Cache\Templating\\'.$name_file;
            $tpl_class = new $path_class($this->dic, $this->dic_t, $this->params, $this->env);
            echo $tpl_class->display();

            $this->ifNoCache('Display'.$type);
        }

        private function dirTemplatingExist(){
            if(Directory::exist('vendor/LFW/Cache/Templating') === false){
                Directory::create('vendor/LFW/Cache/Templating', 0775);
            }
        }

        private function ifNoCache(string $file){
            if($this->cache != 'yes'){
                File::delete('vendor/LFW/Cache/Templating/'.$file.'.php');
            }
        }
	}