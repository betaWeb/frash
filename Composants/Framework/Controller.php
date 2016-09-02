<?php
    namespace Composants\Framework;
    use Composants\Framework\Exception\TwigChargementTemplateFail;
    use Composants\Framework\Globals\Server;
    use Composants\Yaml\Yaml;

    /**
     * Class Controller
     * @package Composants\Framework
     */
    class Controller{
        /**
         * @var array
         */
        private $yaml = [];

        /**
         * @var array
         */
        private $nurl = [];

        /**
         * Controller constructor.
         */
        public function __construct(){
            $this->yaml = Yaml::parse(file_get_contents('Composants/Configuration/config.yml'));
            $this->nurl = explode('/', ltrim(Server::getRequestUri(), '/'));
        }

        /**
         * @param string $templ
         * @param string $bundle
         * @param array $param
         */
        public function view($templ, $bundle, $param = []){
            if(!file_exists('Bundles/'.$bundle.'/Views/'.$templ)){
                return new TwigChargementTemplateFail($templ);
            }

            $twig = new \Twig_Environment(new \Twig_Loader_Filesystem('Bundles/'.$bundle.'/Views'));

            $url = new \Twig_SimpleFunction('url', function ($url, $trad = ''){
                if('/'.$this->nurl[0] == $this->yaml['prefix']){
                    if(in_array($this->nurl[1], $this->yaml['traduction']['available'])){
                        echo ($trad === true) ? '/'.$this->nurl[0].'/'.$url : '/'.$this->nurl[0].'/'.$this->nurl[1].'/'.$url;
                    }
                    else{
                        echo '/'.$this->nurl[0].'/'.$url;
                    }
                }
            });

            $bun = new \Twig_SimpleFunction('bundle', function($bundle, $file){
                if('/'.$this->nurl[0] == $this->yaml['prefix']){
                    echo '/'.$this->nurl[0].'/Bundles/'.$bundle.'Bundle/Ressources/'.$file;
                }
            });

            $trad = new \Twig_SimpleFunction('trad', function($traduction){
                if('/'.$this->nurl[0] == $this->yaml['prefix']){
                    $lang = (in_array($this->nurl[1], $this->yaml['traduction']['available'])) ? $lang = $this->nurl[1] : $lang = $this->yaml['traduction']['default'];
                }

                $class = 'Traductions\\Trad'.ucfirst($lang);
                $tr = new $class;
                echo $tr->show($traduction);
            });

            $twig->addFunction($url);
            $twig->addFunction($bun);
            $twig->addFunction($trad);
            echo $twig->render($templ, $param);
            return true;
        }

        /**
         * @param string $url
         * @return bool
         */
        public function redirectToRoute($url){
            if('/'.$this->nurl[0] == $this->yaml['prefix']){
                $redirect = (in_array($this->nurl[1], $this->yaml['traduction']['available'])) ? $this->nurl[0].'/'.$this->nurl[1] : $this->nurl[0];

                header('Location:/'.$redirect.'/'.$url);
                return true;
            }

            return false;
        }

        /**
         * @param string $url
         * @return bool
         */
        public function redirectToUrl($url){
            header('Location:'.$url);
            return true;
        }

        /**
         * @param string $url
         * @return string
         */
        public function getUrl($url){
            if('/'.$this->nurl[0] == $this->yaml['prefix']){
                return (in_array($this->nurl[1], $this->yaml['traduction']['available'])) ? '/'.$this->nurl[0].'/'.$this->nurl[1].'/'.$url : '/'.$this->nurl[0].'/'.$url;
            }
        }
    }