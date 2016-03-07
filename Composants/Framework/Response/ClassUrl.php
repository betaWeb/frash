<?php
    namespace Composants\Framework\Response;
    use Composants\Yaml\Yaml;

    class ClassUrl{
        public function getUrlForm($url){
            $yaml = Yaml::parse(file_get_contents('Others/config/config.yml'));
            $nurl = explode('/', ltrim($_SERVER['REQUEST_URI'], '/'));

            if($yaml['env'] == 'local'){
                return '/'.$nurl[0].'/'.$url;
            }
            elseif($yaml['env'] == 'prod'){
                return '/'.$url;
            }
        }
    }