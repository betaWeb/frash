<?php
    namespace Composants\Framework\Response;
    use Composants\Yaml\Yaml;

    class ClassUrl{
        public function getUrl($url){
            $yaml = Yaml::parse(file_get_contents('Others/config/config.yml'));
            $nurl = explode('/', ltrim($_SERVER['REQUEST_URI'], '/'));

            if($yaml['env'] == 'local'){
                if($yaml['traduction']['activate'] == 'yes' && in_array($nurl[1], $yaml['traduction']['available'])){
                    return '/'.$nurl[0].'/'.$nurl[1].'/'.$url;
                }
                else{
                    return '/'.$nurl[0].'/'.$url;
                }
            }
            elseif($yaml['env'] == 'prod'){
                if($yaml['traduction']['activate'] == 'yes' && in_array($nurl[0], $yaml['traduction']['available'])){
                    return '/'.$nurl[0].'/'.$url;
                }
                else{
                    return '/'.$url;
                }
            }
        }
    }