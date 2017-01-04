<?php
	namespace LFW\Template\Extensions;
    use LFW\Template\DependTemplEngine;

    /**
     * Class Route
     * @package LFW\Template\Extensions
     */
	class Route{
        /**
         * @var DependTemplEngine
         */
        private $dic_t;

        /**
         * @var array
         */
        private $params = [];

        /**
         * Route constructor.
         * @param DependTemplEngine $dic_t
         * @param array $params
         */
        public function __construct(DependTemplEngine $dic_t, array $params){
            $this->dic_t = $dic_t;
            $this->params = $params;
        }

        /**
         * @param string $route
         * @return string
         */
        public function parse(string $route): string{
            if(strstr($route, '/')){
                $road = explode('/', $route);
                foreach($road as $r){
                    if(!empty($r) && $r[0] == '@'){
                        $route = str_replace($r, $this->dic_t->load('ShowVar')->parse(ltrim($r, '@')), $route);
                    }
                    elseif(!empty($r) && $r[0] == '!'){
                        $route = str_replace($r, $this->dic_t->load('FormatVar')->parseRouteForeach(ltrim($r, '!')), $route);
                    }
                }
            }
            else{
                if($route[0] == '@'){
                    $route = str_replace($route, $this->dic_t->load('ShowVar')->parse(ltrim($route, '@')), $route);
                }
                elseif($route[0] == '!'){
                    $route = str_replace($route, $this->dic_t->load('ShowVar')->parse(ltrim($route, '!')), $route);
                }
            }

            return $this->params['prefix_lang'].'/'.$route;
        }

        /**
         * @param string $route
         * @param string $k
         * @param string $v
         * @return string
         */
        public function parseForeach(string $route, string $k, string $v): string{
            if(strstr($route, '/')){
                $road = explode('/', $route);
                foreach($road as $r){
                    if(!empty($r) && $r[0] == '@'){
                        $route = str_replace($r, $this->dic_t->load('ShowVar')->parse(ltrim($r, '@')), $route);
                    }
                    elseif(!empty($r) && $r[0] == '!'){
                        $ltrim = ltrim($r, '!');
                        if(substr($ltrim, 0, strlen($k)) == $k){
                            $prefix = $k;
                        }
                        elseif(substr($ltrim, 0, strlen($v)) == $v){
                            $prefix = $v;
                        }

                        $route = str_replace($r, $this->dic_t->load('ShowVar')->parseForeach($r, $prefix), $route);
                    }
                }
            }
            else{
                if($route[0] == '@'){
                    $route = str_replace($route, $this->dic_t->load('ShowVar')->parse(ltrim($route, '@')), $route);
                }
                elseif($route[0] == '!'){
                    $route = str_replace($route, $this->dic_t->load('ShowVar')->parse(ltrim($route, '!')), $route);
                }
            }

            return $this->params['prefix_lang'].'/'.$route;
        }
	}