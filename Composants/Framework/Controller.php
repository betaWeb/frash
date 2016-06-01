<?php
    namespace Composants\Framework;
    use Composants\Framework\Exception\TwigChargementTemplateFail;
    use Composants\Yaml\Yaml;

    /**
     * Class Controller
     * @package Composants\Framework
     */
    class Controller{
        /**
         * @param $templ
         * @param $bundle
         * @param array $param
         */
        public function view($templ, $bundle, $param = []){
            if($bundle == 'Exception' && file_exists('Composants/Framework/Exception/Views/'.$templ)){
                $tlf = new \Twig_Loader_Filesystem('Composants/Framework/Exception/Views');
                $twig = new \Twig_Environment($tlf, [ 'cache' => false ]);
                echo $twig->render($templ, $param);
            }
            elseif(file_exists('Bundles/'.$bundle.'/Views/'.$templ)){
                $tlf = new \Twig_Loader_Filesystem('Bundles/'.$bundle.'/Views');
                $twig = new \Twig_Environment($tlf, [ 'cache' => false ]);

                $url = new \Twig_SimpleFunction('url', function($url, $trad = ''){
                    $yaml = Yaml::parse(file_get_contents('Others/config/config.yml'));
                    $nurl = explode('/', ltrim($_SERVER['REQUEST_URI'], '/'));

                    if($yaml['env'] == 'local'){
                        if($trad == 'false' || $yaml['traduction']['activate'] != 'yes'){
                            echo '/'.$nurl['0'].'/'.$url;
                        }
                        elseif($yaml['traduction']['activate'] == 'yes'){
                            echo '/'.$nurl['0'].'/'.$nurl['1'].'/'.$url;
                        }
                    }
                    elseif($yaml['env'] == 'prod'){
                        if($trad == 'false' || $yaml['traduction']['activate'] != 'yes'){
                            echo '/'.$url;
                        }
                        elseif($yaml['traduction']['activate'] == 'yes'){
                            echo '/'.$nurl['0'].'/'.$url;
                        }
                    }
                });

                $trad = new \Twig_SimpleFunction('trad', function($traduction){
                    $yaml = Yaml::parse(file_get_contents('Others/config/config.yml'));
                    $nurl = explode('/', ltrim($_SERVER['REQUEST_URI'], '/'));

                    if($yaml['env'] == 'local'){
                        $lang =  $nurl['1'];
                    }
                    elseif($yaml['env'] == 'prod'){
                        $lang =  $nurl['0'];
                    }

                    $class = 'Traductions\\Trad'.ucfirst($lang);
                    $tr = new $class;
                    echo $tr->show($traduction);
                });

                $twig->addFunction($url);
                $twig->addFunction($trad);
                $twig->addExtension(new \Twig_Extension_Debug());
                echo $twig->render($templ, $param);
                return true;
            }
            else{
                new TwigChargementTemplateFail($templ);
            }
        }

        /**
         * @param $url
         * @return bool
         */
        public function redirect($url){
            $yaml = Yaml::parse(file_get_contents('Others/config/config.yml'));
            $nurl = explode('/', ltrim($_SERVER['REQUEST_URI'], '/'));

            $redirect = '';

            if($yaml['env'] == 'local'){
                if($yaml['traduction']['activate'] == 'yes'){
                    if(empty($nurl['1'])){
                        $redirect = $nurl['0'].'/'.$yaml['traduction']['default'];
                    }
                    else{
                        $redirect = $nurl['0'].'/'.$nurl['1'];
                    }
                }
                else{
                    $redirect = $nurl['0'];
                }
            }
            elseif($yaml['env'] == 'prod'){
                if($yaml['traduction']['activate'] == 'yes'){
                    if(empty($nurl['0'])){
                        $redirect = $yaml['traduction']['default'];
                    }
                    else{
                        $redirect = $nurl['0'];
                    }
                }
                else{
                    $redirect = '';
                }
            }

            if($redirect != ''){
                header('Location:/'.$redirect.'/'.$url);
            }

            return true;
        }

        /**
         * @param $url
         * @return string
         */
        public function getUrl($url){
            $yaml = Yaml::parse(file_get_contents('Others/config/config.yml'));
            $nurl = explode('/', ltrim($_SERVER['REQUEST_URI'], '/'));

            if($yaml['env'] == 'local'){
                if($yaml['traduction']['activate'] == 'yes' && in_array($nurl['1'], $yaml['traduction']['available'])){
                    return '/'.$nurl['0'].'/'.$nurl['1'].'/'.$url;
                }
                else{
                    return '/'.$nurl['0'].'/'.$url;
                }
            }
            elseif($yaml['env'] == 'prod'){
                if($yaml['traduction']['activate'] == 'yes' && in_array($nurl['0'], $yaml['traduction']['available'])){
                    return '/'.$nurl['0'].'/'.$url;
                }
                else{
                    return '/'.$url;
                }
            }
        }
    }