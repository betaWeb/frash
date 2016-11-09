<?php
	namespace LFW\Framework\Templating;
	use LFW\Framework\Templating\Extensions\Routes;

	class Parser{
		private $comment = [];
		private $parent = '';
		private $tpl = '';

		private $parsing = [
			//'call' => [ '(\[call (\w+)\])', '/\[call (\w+)\]/' ], // Call route to execute action in view
			'escape' => [ '(\[escape\])', '/\[escape\]/' ],
			'end_escape' => [ '(\[\/escape\])', '/\[\/escape\]/' ],
			'end_for' => [ '(\[\/for\])', '/\[\/for\]/' ],
			'end_foreach' => [ '(\[\/foreach\])', '/\[\/foreach\]/' ],
			'end_mapper' => [ '(\[\/mapper\])', '/\[\/mapper\]/' ],
			'end_parts' => [ '(\[\/part\])', '/\[\/part\]/' ],			// FAIT
			'for_index' => [ '(\[for_index (\w+)\])', '/\[for_index (\w+)\]/' ], // for(i; 0...10)
			'for_simple' => [ '(\[for_simple (\w+)\])', '/\[for_simple (\w+)\]/' ], // for(i = 0; i <= 10; i++)
			'foreach' => [ '(\[foreach (\w+)\])', '/\[foreach (\w+)\]/' ],
			//'include' => [ '(\[include (\w+)\])', '/\[include (\w+)\]/' ], // include('bundle', 'file.html')
			'mapper' => [ '(\[map (\w+)\])', '/\[map (\w+)\]/' ],
			'parent' => [ '(\[parent this\])', '/\[parent this\]/' ],
			'parts' => [ '(\[part (\w+)\])', '/\[part (\w+)\]/' ],		// FAIT
			'set_var' => [ '(\[@(\w+) (.*)\])', '/\[@(\w+) (.*)\]/' ],	// FAIT
			'show_var' => [ '(\[show (\w+)\])', '/\[show (\w+)\]/' ]	// FAIT
		];

		// {/ /} => Afficher variable
        // Add bottom bar if env == local

        // Filter :
        //      ucfirst
        //      lcfirst
        //      strtoupper

		private $bundle = '';
		private $env = '';
		private $lang = '';
		private $nurl = '';
		private $params = [];

		public function __construct($file, $list){
			$this->tpl = file_get_contents($file);

			$this->bundle = $list['bundle'];
			$this->env = $list['env'];
			$this->lang = $list['lang'];
			$this->nurl = $list['nurl'];
			$this->params = $list['param'];
		    echo '<pre>'; print_r($list['param']); echo '</pre>';
		}

		public function parse(){
			$this->removeComment();
			$this->parseParent();
			$this->importRessourcesBundle();
			$this->importRoutes();
			$this->importTraduction();

			foreach($this->parsing as $name => $regex){
		        $splits[$name] = $regex[0];
		        $matches[$name] = $regex[1];
		    }

		    $res_split = preg_split('/'.implode('|', $splits).'/', $this->tpl, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

			$level_part = 0;
			$parts = [];

			$escape = 0;
			$condition = 0;

			$for_simple = 0;
			$for_index = 0;
			$foreach = 0;
			$mapper = 0;

		    foreach($res_split as $key => $tag){
		    	switch(true){
		    		case (preg_match($matches['escape'], $tag)):
		    			$escape++;
		    			break;
		    		case (preg_match($matches['end_escape'], $tag)):
		    			$escape--;
		    			break;
		    		case ($escape == 0):
		    			switch(true){
		    				case (preg_match($matches['parts'], $tag)):
		    					$level_part++;
			    				$parts[] = [ 'name' => $res_split[ $key + 1 ], 'statut' => 'open' ];
		    					break;
		    				case (preg_match($matches['parent'], $tag)):
		    					$name = $parts[ count($parts) - 1 ]['name'];
		    					break;
		    				case (preg_match($matches['end_parts'], $tag)):
		    					$level_part--;
			    				$parts[ count($parts) - 1 ]['statut'] = 'close';
			    				break;
			    			case (preg_match($matches['set_var'], $tag)):
			    				$this->params[$res_split[ $key + 1 ]] = $res_split[ $key + 2 ];
			    				$this->tpl = str_replace($res_split[ $key ], '', $this->tpl);
			    				break;
			    			case (preg_match($matches['show_var'], $tag)):
			    				$this->tpl = str_replace($res_split[ $key ], $this->params[$res_split[ $key + 1 ]], $this->tpl);
			    				break;
		    			}

		    			break;
		    	}
		    }

			$this->importBottomBar();
		    return $this->tpl;
		}

		private function importBottomBar(){
			if($this->env == 'local'){
				return str_replace('</body>', '<div id="tpl_bottom_bar">Bottom bar</div>'."\n".'    </body>', $this->tpl);
			}
		}

		private function importRessourcesBundle(){
			preg_match_all('/\[bundle (.*?)\]/s', $this->tpl, $matches);

			foreach($matches[1] as $ress){
				if(strstr($ress, ' ')){
					list($file, $bundle) = explode(' ', $ress);
				}
				else{
					$file = $ress;
					$bundle = $this->bundle;
				}

				$this->tpl = str_replace('[bundle '.$ress.']', '/Bundles/'.$bundle.'/Ressources/'.$file, $this->tpl);
			}
		}

		private function importRoutes(){
			preg_match_all('/\[route (.*?)\]/s', $this->tpl, $matches);
			Routes::setJson();

			foreach($matches[1] as $route){
				$this->tpl = str_replace('[route '.$route.']', Routes::parse($route, $this->nurl), $this->tpl);
			}
		}

		private function importTraduction(){
			preg_match_all('/\[traduction (.*?)\]/s', $this->tpl, $matches);

			$class = 'Traductions\\Trad'.ucfirst($this->lang);
			$tr = new $class;

			foreach($matches[1] as $trad){
				$this->tpl = str_replace('[traduction '.$trad.']', $tr->show($trad), $this->tpl);
			}
		}

		private function parseParent(){
			preg_match('/\[extend\](.*)\[\/extend\]/s', $this->tpl, $match);
			list($bundle, $file) = explode('::', $match[1]);
			$this->parent = file_get_contents('Bundles/'.$bundle.'/Views/'.$file);
			$this->tpl = str_replace($match[0], '', $this->tpl);
		}

		private function removeComment(){
			preg_match_all('/\[comment\](.*?)\[\/comment\]/s', $this->tpl, $matches);

			foreach($matches[1] as $comment){
				$this->comment[] = $comment;
				$this->tpl = str_replace('[comment]'.$comment.'[/comment]', '', $this->tpl);
			}
		}
	}