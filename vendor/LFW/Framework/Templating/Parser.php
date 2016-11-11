<?php
	namespace LFW\Framework\Templating;
	use LFW\Framework\Templating\Extensions\RemoveComment;
	use LFW\Framework\Templating\Extensions\Import\ImportRessourcesBundle;
	use LFW\Framework\Templating\Parsing\ParseWithExtend;
	use LFW\Framework\Templating\Parsing\ParseWithoutExtend;

	class Parser{
		private $comment = [];
		private $name_parts = [];
		private $tpl = '';

		private $parsing = [
			'bundle' => '/\[bundle (.*?)\]/',
			//'call' => '/\[call (\w+)\]/', // Call route to execute action in view
			'escape' => '/\[escape\]/',
			'end_escape' => '/\[\/escape\]/',
			'end_for' => '/\[\/for\]/',
			'end_foreach' => '/\[\/foreach\]/',
			'end_mapper' => '/\[\/mapper\]/',
			'end_parts' => '/\[\/part (\w+)\]/',
			'for_index' => '/\[for_index (\w+)\]/', // for(i; 0...10)
			'for_simple' => '/\[for_simple (\w+)\]/', // for(i = 0; i <= 10; i++)
			'foreach' => '/\[foreach (\w+)\]/',
			//'include' => '/\[include (\w+)\]/', // include('bundle', 'file.html')
			'mapper' => '/\[map (\w+)\]/',
			'parent' => '/\[parent this\]/',
			'parts' => '/\[part (\w+)\]/',
			'route' => '/\[route (.*)]/',
			'set_var' => '/\[@(\w+) (.*)\]/',
			'show_var' => '/\[show (.*)\]/',
			'traduction' => '/\[traduction (.*?)\]/'
		];

		// For the loop, capture syntax and contenu, generate file with this and include

		private $bundle = '';
		private $env = '';
		private $lang = '';
		private $nurl = [];
		private $params = [];

		public function __construct($file, $list){
			$this->tpl = file_get_contents($file);

			$this->bundle = $list['bundle'];
			$this->env = $list['env'];
			$this->lang = $list['lang'];
			$this->nurl = $list['nurl'];
			$this->params = $list['param'];
		}

		public function parse(){
			$this->removeComment();
			$recense = $this->recenseExtend();

			if($recense == ''){
				$parse = new ParseWithoutExtend;
				$tpl = $parse->parse($this->parsing, $this->tpl, $this->bundle, $this->nurl, $this->params, $this->lang, $this->recensePart());
			}
			else{
				$parse = new ParseWithExtend($recense, $this->bundle, $this->lang, $this->params, $this->parsing, $this->nurl);
				$tpl = $parse->parse($this->tpl, $this->recensePart());
			}

		    $tpl = $this->removeBalisePart($tpl);
			$tpl = $this->importBottomBar($tpl);
			echo $tpl;
		}

		private function importBottomBar($tpl){
			if($this->env == 'local'){
				return str_replace('</body>', '<div id="tpl_bottom_bar"></div>'."\n".'    </body>', $tpl);
			}
		}

		private function recenseExtend(){
			preg_match('/\[extend\](.*)\[\/extend\]/s', $this->tpl, $match);

			if(!empty($match)){
				$this->tpl = preg_replace('/\[extend\](.*)\[\/extend\]/s', '', $this->tpl);
				return $match[1];
			}

			return '';
		}

		private function recensePart(){
			preg_match_all('/\[part (\w+)\]/s', $this->tpl, $matches);

			$name_parts = [];
			foreach($matches[1] as $part){
				$name_parts[ $part ] = 'close';
			}

			return $name_parts;
		}

		private function removeBalisePart($tpl){
			$tpl = preg_replace('/\[part (\w+)\]/', '', $tpl);
			$tpl = preg_replace('/\[\/part (\w+)\]/', '', $tpl);

			return $tpl;
		}

		private function removeComment(){
			$remove = RemoveComment::remove($this->tpl);
			$this->comment = $remove['comment'];
			$this->tpl = $remove['tpl'];
		}
	}