<?php
    namespace Composants\Framework\Response;
    use Composants\Framework\Exception\TwigChargementTemplateFail;

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
                echo $twig->render($templ, $param);
            }
            else{
                new TwigChargementTemplateFail($templ);
            }
        }
    }