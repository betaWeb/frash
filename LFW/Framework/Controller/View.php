<?php
    namespace Composants\Framework\Controller;
    use Composants\Framework\Exception\Exception;
    use Composants\Framework\Globals\Server;
    use Symfony\Component\Yaml\Yaml;

    /**
     * Class View
     * @package Composants\Framework\Controller
     */
    class View{
        /**
         * @var string
         */
        private $bundle = '';

        /**
         * @var array
         */
        private $nurl = [];

        /**
         * @var array
         */
        private $yaml = [];

        /**
         * @param string $templ
         * @param string $bundle
         * @param array $param
         * @return Exception|bool
         */
        public function view($templ, $bundle, $param = []){
            if(!file_exists('Bundles/'.$bundle.'Bundle/Views/'.$templ)){
                return new Exception('TWIG : Template '.$templ.' not found');
            }

            $this->yaml = Yaml::parse(file_get_contents('Composants/Configuration/config.yml'));
            $tlf = new \Twig_Loader_Filesystem('Bundles/'.$bundle.'Bundle/Views');
            $twig = ($this->yaml['cache']['TWIG'] == 'yes') ? new \Twig_Environment($tlf, [ 'cache' => 'Composants/Cache/TWIG' ]) : new \Twig_Environment($tlf);

            $this->bundle = $bundle.'Bundle';
            $this->nurl = explode('/', ltrim(Server::getRequestUri(), '/'));

            $url = new \Twig_SimpleFunction('url', function($url, $trad = ''){
                if('/'.$this->nurl[0] == $this->yaml['prefix']){
                    if(in_array($this->nurl[1], $this->yaml['traduction']['available'])){
                        echo ($trad === true) ? '/'.$this->nurl[0].'/'.$url : '/'.$this->nurl[0].'/'.$this->nurl[1].'/'.$url;
                    }
                    else{
                        echo '/'.$this->nurl[0].'/'.$url;
                    }
                }
                else{
                    if(in_array($this->nurl[0], $this->yaml['traduction']['available'])){
                        echo ($trad === true) ? '/'.$url : '/'.$this->nurl[0].'/'.$url;
                    }
                    else{
                        echo $url;
                    }
                }
            });

            $bun = new \Twig_SimpleFunction('bundle', function($file, $bundle = false){
                $bu = ($bundle === false) ? $this->bundle : $bundle.'Bundle';
                $base = '/Bundles/'.$bu.'/Ressources/'.$file;

                if('/'.$this->nurl[0] == $this->yaml['prefix']){
                    echo '/'.$this->nurl[0].$base;
                }
                else{
                    echo $base;
                }
            });

            $trad = new \Twig_SimpleFunction('trad', function($traduction){
                if('/'.$this->nurl[0] == $this->yaml['prefix']){
                    $lang = (in_array($this->nurl[1], $this->yaml['traduction']['available'])) ? $this->nurl[1] : $this->yaml['traduction']['default'];
                }
                else{
                    $lang = (in_array($this->nurl[0], $this->yaml['traduction']['available'])) ? $this->nurl[0] : $this->yaml['traduction']['default'];
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
         * @param string $file
         * @param string $path
         * @param array $param
         * @return bool|Exception
         */
        public function viewDev($file, $path, $param = []){
            if(!file_exists($path.$file)){
                return new Exception('TWIG : '.$path.$file.' not found');
            }

            $tlf = new \Twig_Loader_Filesystem('Bundles/'.$bundle.'Bundle/Views');
            $twig = new \Twig_Environment($tlf, [ 'cache' => 'Composants/Cache/TWIG' ]);

            $this->nurl = explode('/', ltrim(Server::getRequestUri(), '/'));
            $this->yaml = Yaml::parse(file_get_contents('Composants/Configuration/config.yml'));

            $url = new \Twig_SimpleFunction('url', function($url, $trad = ''){
                if('/'.$this->nurl[0] == $this->yaml['prefix']){
                    if(in_array($this->nurl[1], $this->yaml['traduction']['available'])){
                        echo ($trad === true) ? '/'.$this->nurl[0].'/'.$url : '/'.$this->nurl[0].'/'.$this->nurl[1].'/'.$url;
                    }
                    else{
                        echo '/'.$this->nurl[0].'/'.$url;
                    }
                }
                else{
                    if(in_array($this->nurl[0], $this->yaml['traduction']['available'])){
                        echo ($trad === true) ? '/'.$url : '/'.$this->nurl[0].'/'.$url;
                    }
                    else{
                        echo $url;
                    }
                }
            });

            $comp = new \Twig_SimpleFunction('comp', function($file){
                $base = '/Composants/Framework/Systems/Ressources/css/'.$file;

                if('/'.$this->nurl[0] == $this->yaml['prefix']){
                    echo '/'.$this->nurl[0].$base;
                }
                else{
                    echo $base;
                }
            });

            $trad = new \Twig_SimpleFunction('trad', function($traduction){
                if('/'.$this->nurl[0] == $this->yaml['prefix']){
                    $lang = (in_array($this->nurl[1], $this->yaml['traduction']['available'])) ? $this->nurl[1] : $this->yaml['traduction']['default'];
                }
                else{
                    $lang = (in_array($this->nurl[0], $this->yaml['traduction']['available'])) ? $this->nurl[0] : $this->yaml['traduction']['default'];
                }

                $class = 'Traductions\\Trad'.ucfirst($lang);
                $tr = new $class;
                echo $tr->show($traduction);
            });

            $twig->addFunction($comp);
            $twig->addFunction($url);
            $twig->addFunction($trad);
            echo $twig->render($file, $param);
            return true;
        }
    }