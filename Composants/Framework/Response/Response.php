<?php
    namespace Composants\Framework\Response;
    use Composants\Framework\Exception\TwigChargementTemplateFail;
    use Composants\Yaml\Yaml;

    /**
     * Class Response
     * @package Composants\Framework\Response
     */
    class Response{
        /**
         * @param $templ
         * @param $bundle
         * @param array $param
         */
        public function HTTPres($templ, $bundle, $param = []){
            if($bundle == 'Exception' && file_exists('Composants/Framework/Exception/Views/'.$templ)){
                $tlf = new \Twig_Loader_Filesystem('Composants/Framework/Exception/Views');
                $twig = new \Twig_Environment($tlf, [ 'cache' => false ]);
                echo $twig->render($templ, $param);
            }
            elseif(file_exists('Bundles/'.$bundle.'/Views/'.$templ)){
                $tlf = new \Twig_Loader_Filesystem('Bundles/'.$bundle.'/Views');
                $twig = new \Twig_Environment($tlf, [ 'cache' => false ]);

                $url = new \Twig_SimpleFunction('url', function($url, $trad = false){
                    $yaml = Yaml::parse(file_get_contents('Others/config/config.yml'));
                    $nurl = explode('/', ltrim($_SERVER['REQUEST_URI'], '/'));

                    if($yaml['env'] == 'local'){
                        if($trad === true){
                            echo '/'.$nurl[0].'/'.$nurl[1].'/'.$url;
                        }
                        else{
                            echo '/'.$nurl[0].'/'.$url;
                        }
                    }
                    elseif($yaml['env'] == 'prod'){
                        if($trad === true){
                            echo '/'.$nurl[0].'/'.$url;
                        }
                        else{
                            echo '/'.$url;
                        }
                    }
                });

                $trad = new \Twig_SimpleFunction('trad', function($traduction){
                    $yaml = Yaml::parse(file_get_contents('Others/config/config.yml'));
                    $nurl = explode('/', ltrim($_SERVER['REQUEST_URI'], '/'));

                    if($yaml['env'] == 'local'){
                        $lang =  $nurl[1];
                    }
                    elseif($yaml['env'] == 'prod'){
                        $lang =  $nurl[0];
                    }

                    $class = 'Traductions\\Trad'.ucfirst($lang);
                    $tr = new $class;
                    echo $tr->show($traduction);
                });

                $twig->addFunction($url);
                $twig->addFunction($trad);
                echo $twig->render($templ, $param);
            }
            else{
                new TwigChargementTemplateFail($templ);
            }
        }

        /**
         * @param $url
         */
        public function redirect($url){
            header('Location:'.$url);
        }
    }