<?php
    namespace LFW\Framework\Controller;
    use LFW\Framework\DIC\Dic;
    use LFW\Framework\Exception\Exception;

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
         * View constructor.
         * @param Dic $dic
         */
        public function __construct(Dic $dic){
            $gets = $dic->load('get');
            $this->bundle = $gets->get('bundle');
            $this->nurl = explode('/', $gets->get('uri'));
        }

        /**
         * @param string $templ
         * @param mixed $bundle
         * @param array $param
         * @return Exception|bool
         */
        public function view($templ, $bundle, $param = []){
            if(is_array($bundle)){
                $params = $bundle;
            }
            else{
                $params = $param;
                $this->bundle = $bundle.'Bundle';
            }

            if(!file_exists('Bundles/'.$this->bundle.'/Views/'.$templ)){
                return new Exception('TWIG : Template '.$templ.' not found');
            }

            $this->json = json_decode(file_get_contents('Configuration/config.json'), true);
            $tlf = new \Twig_Loader_Filesystem('Bundles/'.$this->bundle.'/Views');
            $twig = ($this->json['cache']['TWIG'] == 'yes') ? new \Twig_Environment($tlf, [ 'cache' => 'vendor/LFW/Cache/TWIG' ]) : new \Twig_Environment($tlf);

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
                $lang = ('/'.$this->nurl[0] == $this->json['prefix'] && $this->json['prefix'] != '/') ? $this->nurl[1] : $lang = $this->nurl[0];
                $def_lang = (in_array($lang, $this->json['traduction']['available'])) ? $lang : $this->json['traduction']['default'];

                $class = 'Traductions\\Trad'.ucfirst($lang);
                $tr = new $class;
                echo $tr->show($traduction);
            });

            $jquery = new \Twig_SimpleFunction('jquery', function(){ echo '<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>'; });
            $jquery_ui = new \Twig_SimpleFunction('jquery_ui', function(){ echo '<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>'; });

            $twig->addFunction($url);
            $twig->addFunction($bun);
            $twig->addFunction($trad);
            $twig->addFunction($jquery);
            $twig->addFunction($jquery_ui);

            echo $twig->render($templ, $params);
            return true;
        }
    }