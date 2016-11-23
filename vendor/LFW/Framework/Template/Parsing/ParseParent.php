<?php
	namespace LFW\Framework\Template\Parsing;
	use LFW\Framework\Template\Parsing\ParseArray;

    /**
     * Class ParseParent
     * @package LFW\Framework\Template\Parsing
     */
	class ParseParent extends ParseArray{
        /**
         * @var string
         */
		private $bundle = '';

        /**
         * @var string
         */
		private $tpl = '';

        /**
         * @var string
         */
		private $trad = '';

        /**
         * ParseParent constructor.
         * @param string $trad
         * @param string $bundle
         * @param string $tpl
         */
		public function __construct($trad, $bundle, $tpl){
			$this->bundle = $bundle;
			$this->tpl = $tpl;
			$this->trad = $trad;
		}

        /**
         * @param string $name
         * @param string $value
         * @return string
         */
		public function parse($name, $value){
			$level_escape = 0;

			$complement = '		public function parent'.ucfirst($name).'(){'."\n";
			$complement .= '			return \''.trim($value).'\';'."\n";
			$complement .= '		}'."\n\n";

			$treatment = '';
			preg_match_all('/\[(\/?)(([a-z]*)?\s?([a-z\/@_!=:,\.\s]*))\]/', $value, $res_split, PREG_SET_ORDER);
			foreach($res_split as $key => $tag){
				switch(true){
					case $level_escape == 0:
						break;
				}
			}

			return $complement.$treatment;
		}
	}