<?php
	namespace LFW\Framework\Template\Extensions;

	class Route{
        private $dic_t;
        private $params;

        public function __construct($dic_t, $params){
            $this->dic_t = $dic_t;
            $this->params = $params;
        }

        public function parse($route){
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

            if('/'.$this->params['nurl'][0] == $this->params['json']['prefix'] && $this->params['json']['prefix'] != '/'){
                if(in_array($this->params['nurl'][1], $this->params['json']['traduction']['available'])){
                    return '/'.$this->params['nurl'][0].'/'.$this->params['nurl'][1].'/'.$route;
                }
                else{
                    return '/'.$this->params['nurl'][0].'/'.$route;
                }
            }
            else{
                if(in_array($this->params['nurl'][0], $this->params['traduction']['available'])){
                    return '/'.$this->params['nurl'][0].'/'.$route;
                }
                else{
                    return $route;
                }
            }
        }

        public function parseForeach($route, $k, $v){
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

            if('/'.$this->params['nurl'][0] == $this->params['json']['prefix'] && $this->params['json']['prefix'] != '/'){
                if(in_array($this->params['nurl'][1], $this->params['json']['traduction']['available'])){
                    return '/'.$this->params['nurl'][0].'/'.$this->params['nurl'][1].'/'.$route;
                }
                else{
                    return '/'.$this->params['nurl'][0].'/'.$route;
                }
            }
            else{
                if(in_array($this->params['nurl'][0], $this->params['traduction']['available'])){
                    return '/'.$this->params['nurl'][0].'/'.$route;
                }
                else{
                    return $route;
                }
            }
        }
	}