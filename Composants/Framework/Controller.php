<?php
    namespace Composants\Framework;
    use Composants\Framework\CreateLog\CreateErrorLog;
    use Composants\Framework\Exception\ConnexionORMFail;
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
            self::$yaml = Yaml::parse(file_get_contents('Others/config/config.yml'));
            self::$nurl = explode('/', ltrim(Server::getRequestUri(), '/'));
        }

        /**
         * @param string $templ
         * @param string $bundle
         * @param array $param
         */
        public function view($templ, $bundle, $param = []){
            if($bundle == 'Exception' && file_exists('Composants/Framework/Exception/Views/'.$templ)){
                $path = 'Composants/Framework/Exception/Views/';
            }
            elseif(file_exists('Bundles/'.$bundle.'/Views/'.$templ)){
                $path = 'Bundles/'.$bundle.'/Views';
            }
            else{
                return new TwigChargementTemplateFail($templ);
            }

            $tlf = new \Twig_Loader_Filesystem($path);
            $twig = new \Twig_Environment($tlf, [ 'cache' => false ]);

            $url = new \Twig_SimpleFunction('url', function ($url, $trad = ''){
                if('/'.self::$nurl[0] == self::$yaml['prefix']){
                    if(in_array(self::$nurl[1], self::$yaml['traduction']['available'])){
                        if($trad === true){
                            echo '/'.self::$nurl[0].'/'.$url;
                        }
                        else{
                            echo '/'.self::$nurl[0].'/'.self::$nurl[1].'/'.$url;
                        }
                    }
                    else{
                        echo '/'.self::$nurl[0].'/'.$url;
                    }
                }
            });

            $trad = new \Twig_SimpleFunction('trad', function($traduction){
                if('/'.self::$nurl[0] == self::$yaml['prefix']){
                    if(in_array(self::$nurl[1], self::$yaml['traduction']['available'])){
                        $lang = self::$nurl[1];
                    }
                    else{
                        $lang = self::$yaml['traduction']['default'];
                    }
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
            $redirect = '';

            if('/'.self::$nurl[0] == self::$yaml['prefix']){
                if(in_array(self::$nurl[1], self::$yaml['traduction']['available'])){
                    $redirect = self::$nurl[0].'/'.self::$nurl[1];
                }
                else{
                    $redirect = self::$nurl[0];
                }
            }

            if($redirect != ''){
                header('Location:/'.$redirect.'/'.$url);
                return true;
            }
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
                if(in_array(self::$nurl[1], self::$yaml['traduction']['available'])){
                    return '/'.self::$nurl[0].'/'.self::$nurl[1].'/'.$url;
                }
                else{
                    return '/'.self::$nurl[0].'/'.$url;
                }
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
            $conn = Yaml::parse(file_get_contents('Others/config/database.yml'));

            $host = $conn[ $bundle ]['host'];
            $dbname = $conn[ $bundle ]['dbname'];
            $username = $conn[ $bundle ]['username'];
            $password = $conn[ $bundle ]['password'];
            $system = $conn[ $bundle ]['system'];

            try{
                if($system == 'MySQL'){
                    self::$connexion = new \PDO('mysql:host='.$host.';dbname='.$dbname.';charset=UTF8;', $username, $password, [ \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC ]);
                }
                elseif($system == 'PGSQL'){
                    self::$connexion = new \PDO('pgsql:dbname='.$dbname.';host='.$host, $username, $password);
                    self::$connexion->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                }
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                return new ConnexionORMFail();
            }
        }

        /**
         * @return \PDO
         */
        public static function getConnexion(){
            return self::$connexion;
        }
    }