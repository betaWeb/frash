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
         * Response constructor.
         * @param $templ
         * @param $bundle
         * @param array $param
         */
        public function __construct($templ, $bundle, $param = []){
            if($bundle == 'Exception' && file_exists('Composants/Framework/Exception/Views/'.$templ)){
                $tlf = new \Twig_Loader_Filesystem('Composants/Framework/Exception/Views');
                $twig = new \Twig_Environment($tlf, [ 'cache' => false ]);
                echo $twig->render($templ, $param);
            }
            elseif(file_exists('Bundles/'.$bundle.'/Views/'.$templ)){
                $tlf = new \Twig_Loader_Filesystem('Bundles/'.$bundle.'/Views');
                $twig = new \Twig_Environment($tlf, [ 'cache' => false ]);

                $url = new \Twig_SimpleFunction('url', function($url){
                    $yaml = Yaml::parse(file_get_contents('Others/config/config.yml'));
                    $nurl = explode('/', ltrim($_SERVER['REQUEST_URI'], '/'));

                    if($yaml['env'] == 'local'){
                        echo '/'.$nurl[0].'/'.$url.'/';
                    }
                    elseif($yaml['env'] == 'prod'){
                        echo '/'.$url.'/';
                    }
                });

                $twig->addFunction($url);
                echo $twig->render($templ, $param);
            }
            else{
                new TwigChargementTemplateFail($templ);
            }
        }
    }