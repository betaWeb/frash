<?php
    namespace Composants\Framework;
    use Composants\Framework\Exception\ConnexionORMFail;
    use Composants\Framework\Exception\TwigChargementTemplateFail;
    use Composants\Framework\Globals\Server;
    use Composants\ORM\VerifParamDbYaml;
    use Composants\Yaml\Yaml;

    /**
     * Class Controller
     * @package Composants\Framework
     */
    class Controller{
        /**
         * @var array
         */
        private static $yaml = [];

        /**
         * @var array
         */
        private static $nurl = [];

        /**
         * @var \PDO
         */
        private static $connexion;

        /**
         * Controller constructor.
         */
        public function __construct(){
            self::$yaml = Yaml::parse(file_get_contents('Composants/Configuration/config.yml'));
            self::$nurl = explode('/', ltrim(Server::getRequestUri(), '/'));
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
                if('/'.self::$nurl[0] == self::$yaml['prefix']){
                    if(in_array(self::$nurl[1], self::$yaml['traduction']['available'])){
                        echo ($trad === true) ? '/'.self::$nurl[0].'/'.$url : '/'.self::$nurl[0].'/'.self::$nurl[1].'/'.$url;
                    }
                    else{
                        echo '/'.self::$nurl[0].'/'.$url;
                    }
                }
            });

            $trad = new \Twig_SimpleFunction('trad', function($traduction){
                if('/'.self::$nurl[0] == self::$yaml['prefix']){
                    $lang = (in_array(self::$nurl[1], self::$yaml['traduction']['available'])) ? $lang = self::$nurl[1] : $lang = self::$yaml['traduction']['default'];
                }

                $class = 'Traductions\\Trad'.ucfirst($lang);
                $tr = new $class;
                echo $tr->show($traduction);
            });

            $twig->addFunction($url);
            $twig->addFunction($trad);
            echo $twig->render($templ, $param);
            return true;
        }

        /**
         * @param string $url
         * @return bool
         */
        public function redirectToRoute($url){
            if('/'.self::$nurl[0] == self::$yaml['prefix']){
                $redirect = (in_array(self::$nurl[1], self::$yaml['traduction']['available'])) ? self::$nurl[0].'/'.self::$nurl[1] : self::$nurl[0];

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
        public static function getUrl($url){
            if('/'.self::$nurl[0] == self::$yaml['prefix']){
                return (in_array(self::$nurl[1], self::$yaml['traduction']['available'])) ? '/'.self::$nurl[0].'/'.self::$nurl[1].'/'.$url : '/'.self::$nurl[0].'/'.$url;
            }
        }

        /**
         * @param string $type_form
         * @param array $spec
         * @return string
         */
        public function createForm($type_form, $spec){
            $routing = 'Composants\\Framework\\Utility\\Forms\\Type\\'.$type_form;
            $type = new $routing($spec);
            return $type->getInput();
        }

        /**
         * @param string $bundle
         * @return ConnexionORMFail
         */
        public static function initORM($bundle){
            if(!file_exists('Others/config/database.yml')){ return new ConnexionORMFail('Le fichier database.yml n\'existe pas.'); }

            $yaml = Yaml::parse(file_get_contents('Composants/Configuration/database.yml'));

            if(empty($yaml[ $bundle ])){ return new ConnexionORMFail('Le bundle '.$bundle.' n\'existe pas.'); }

            $conn = $yaml[ $bundle ];
            new VerifParamDbYaml($conn, [ 'host', 'dbname', 'username', 'password', 'system' ]);

            try{
                switch($conn['system']){
                    case 'MySQL':
                        self::$connexion = new \PDO('mysql:host='.$conn['host'].';dbname='. $conn['dbname'].';charset=UTF8;', $conn['username'], $conn['password']);
                        break;
                    case 'PGSQL':
                        self::$connexion = new \PDO('pgsql:dbname='. $conn['dbname'].';host='.$conn['host'], $conn['username'], $conn['password']);
                        self::$connexion->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                        break;
                }
            }
            catch(\Exception $e){
                return new ConnexionORMFail($e->getMessage());
            }
        }

        /**
         * @return \PDO
         */
        public static function getConnexion(){
            return self::$connexion;
        }
    }