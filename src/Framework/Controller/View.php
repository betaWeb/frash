<?php
namespace LFW\Framework\Controller;
use LFW\Framework\DIC\Dic;
use LFW\Framework\Exception\Exception;
use LFW\Framework\FileSystem\Json;

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
     * @var Dic
     */
    private $dic;

    /**
     * @var object
     */
    private $gets;

    /**
     * @var array
     */
    private $json = [];

    /**
     * @var array
     */
    private $nurl = [];

    /**
     * @var string
     */
    private $prefix = '';

    /**
     * View constructor.
     * @param Dic $dic
     */
    public function __construct(Dic $dic){
        $this->dic = $dic;
        $this->gets = $this->dic->load('get');
        $this->bundle = $this->gets->get('bundle');
        $this->nurl = explode('/', $this->gets->get('uri'));
        $this->prefix = $this->gets->get('prefix');
    }

    /**
     * @param string $templ
     * @param mixed $bundle
     * @param array $param
     * @return Exception|bool
     */
    public function view(string $templ, $bundle, array $param = []){
        if(is_array($bundle)){
            $params = $bundle;
        } else {
            $params = $param;
            $this->bundle = $bundle.'Bundle';
        }

        if(!file_exists('Bundles/'.$this->bundle.'/Views/'.$templ)){
            return new Exception('TWIG : Template '.$templ.' not found', $this->dic->get('conf')['config']['log']);
        }

        $this->json = (array) Json::importConfig();
        $tlf = new \Twig_Loader_Filesystem('Bundles/'.$this->bundle.'/Views');
        $twig = ($this->gets->get('cache_tpl') == 'yes') ? new \Twig_Environment($tlf, [ 'cache' => 'vendor/LFW/Cache/TWIG' ]) : new \Twig_Environment($tlf);

        $url = new \Twig_SimpleFunction('url', function($url, $trad = ''){
            if('/'.$this->nurl[0] == $this->prefix && $this->prefix != '/'){
                if(in_array($this->nurl[1], $this->json['traduction']['available'])){
                    echo ($trad === true) ? '/'.$this->nurl[0].'/'.$url : '/'.$this->nurl[0].'/'.$this->nurl[1].'/'.$url;
                } else {
                    echo '/'.$this->nurl[0].'/'.$url;
                }
            } else {
                if(in_array($this->nurl[0], $this->json['traduction']['available'])){
                    echo ($trad === true) ? '/'.$url : '/'.$this->nurl[0].'/'.$url;
                } else {
                    echo $url;
                }
            }
        });

        $bun = new \Twig_SimpleFunction('bundle', function($file, $bundle = false){
            $bu = ($bundle === false) ? $this->bundle : $bundle.'Bundle';
            $base = '/Bundles/'.$bu.'/Ressources/'.$file;

            if('/'.$this->nurl[0] == $this->prefix && $this->prefix != '/'){
                echo '/'.$this->nurl[0].$base;
            } else {
                echo $base;
            }
        });

        $trad = new \Twig_SimpleFunction('trad', function($traduction){
            $lang = ('/'.$this->nurl[0] == $this->prefix && $this->prefix != '/') ? $this->nurl[1] : $lang = $this->nurl[0];
            $def_lang = (in_array($lang, $this->json['traduction']['available'])) ? $lang : $this->json['traduction']['default'];

            $class = 'Traductions\\Trad'.ucfirst($lang);
            $tr = new $class;
            echo $tr->show($traduction);
        });

        $twig->addFunction($url);
        $twig->addFunction($bun);
        $twig->addFunction($trad);

        echo $twig->render($templ, $params);
        return true;
    }
}