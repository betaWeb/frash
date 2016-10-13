<?php
    namespace LFW\Framework\Controller;
    use LFW\Framework\Exception\Exception;
    use LFW\Framework\Globals\Server;

    /**
     * Class View
     * @package LFW\Framework\Controller
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
        private $json = [];

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

            $this->yaml = json_decode(file_get_contents('vendor/LFW/Configuration/config.json'), true);
            $tlf = new \Twig_Loader_Filesystem('Bundles/'.$bundle.'Bundle/Views');
            $twig = ($this->json['cache']['TWIG'] == 'yes') ? new \Twig_Environment($tlf, [ 'cache' => 'vendor/LFW/Cache/TWIG' ]) : new \Twig_Environment($tlf);

            $this->bundle = $bundle.'Bundle';
            $this->nurl = explode('/', Server::getReqUriTrim());

            $url = new \Twig_SimpleFunction('url', function($url, $trad = ''){
                if('/'.$this->nurl[0] == $this->json['prefix'] && $this->json['prefix'] != '/'){
                    if(in_array($this->nurl[1], $this->json['traduction']['available'])){
                        echo ($trad === true) ? '/'.$this->nurl[0].'/'.$url : '/'.$this->nurl[0].'/'.$this->nurl[1].'/'.$url;
                    }
                    else{
                        echo '/'.$this->nurl[0].'/'.$url;
                    }
                }
                else{
                    if(in_array($this->nurl[0], $this->json['traduction']['available'])){
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

                if('/'.$this->nurl[0] == $this->json['prefix'] && $this->json['prefix'] != '/'){
                    echo '/'.$this->nurl[0].$base;
                }
                else{
                    echo $base;
                }
            });

            $trad = new \Twig_SimpleFunction('trad', function($traduction){
                if('/'.$this->nurl[0] == $this->json['prefix'] && $this->json['prefix'] != '/'){
                    $lang = (in_array($this->nurl[1], $this->json['traduction']['available'])) ? $this->nurl[1] : $this->json['traduction']['default'];
                }
                else{
                    $lang = (in_array($this->nurl[0], $this->json['traduction']['available'])) ? $this->nurl[0] : $this->json['traduction']['default'];
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
    }