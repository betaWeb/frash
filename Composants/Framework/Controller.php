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
        private $yaml = [];

        /**
         * @var array
         */
        private $nurl = [];

        /**
         * @var string
         */
        protected $bundle = '';

        /**
         * @var mixed
         */
        private $connexion;

        /**
         * Controller constructor.
         */
        public function __construct(){
            $this->yaml = Yaml::parse(file_get_contents('Others/config/config.yml'));
            $this->nurl = explode('/', ltrim(Server::getRequestUri(), '/'));
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
                if($this->yaml['env'] == 'local'){
                    $echo = '/'.$this->nurl['0'].'/';

                    if($trad == 'false' || $this->yaml['traduction']['activate'] != 'yes'){
                        echo $echo.$url;
                    }
                    elseif($this->yaml['traduction']['activate'] == 'yes'){
                        echo $echo.$this->nurl['1'].'/'.$url;
                    }
                }
                elseif($this->yaml['env'] == 'prod'){
                    if($trad == 'false' || $this->yaml['traduction']['activate'] != 'yes'){
                        echo '/'.$url;
                    }
                    elseif($this->yaml['traduction']['activate'] == 'yes'){
                        echo '/'.$this->nurl['0'].'/'.$url;
                    }
                }
            });

            $trad = new \Twig_SimpleFunction('trad', function($traduction){
                if($this->yaml['env'] == 'local'){
                    $lang = $this->nurl['1'];
                }
                elseif($this->yaml['env'] == 'prod'){
                    $lang = $this->nurl['0'];
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

            if($this->yaml['env'] == 'local'){
                if($this->yaml['traduction']['activate'] == 'yes'){
                    if(empty($this->nurl['1'])){
                        $redirect = $this->nurl['0'].'/'.$this->yaml['traduction']['default'];
                    }
                    else{
                        $redirect = $this->nurl['0'].'/'.$this->nurl['1'];
                    }
                }
                else{
                    $redirect = $this->nurl['0'];
                }
            }
            elseif($this->yaml['env'] == 'prod'){
                if($this->yaml['traduction']['activate'] == 'yes'){
                    if(empty($this->nurl['0'])){
                        $redirect = $this->yaml['traduction']['default'];
                    }
                    else{
                        $redirect = $this->nurl['0'];
                    }
                }
                else{
                    $redirect = '';
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
        public function getUrl($url){
            if($this->yaml['env'] == 'local'){
                if($this->yaml['traduction']['activate'] == 'yes' && in_array($this->nurl['1'], $this->yaml['traduction']['available'])){
                    return '/'.$this->nurl['0'].'/'.$this->nurl['1'].'/'.$url;
                }
                else{
                    return '/'.$this->nurl['0'].'/'.$url;
                }
            }
            elseif($this->yaml['env'] == 'prod'){
                if($this->yaml['traduction']['activate'] == 'yes' && in_array($this->nurl['0'], $this->yaml['traduction']['available'])){
                    return '/'.$this->nurl['0'].'/'.$url;
                }
                else{
                    return '/'.$url;
                }
            }
        }

        /**
         * @param string $type_form
         * @param mixed $spec
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
        public function initORM($bundle){
            $conn = Yaml::parse(file_get_contents('Others/config/database.yml'));

            $host = $conn[ $bundle ]['host'];
            $dbname = $conn[ $bundle ]['dbname'];
            $username = $conn[ $bundle ]['username'];
            $password = $conn[ $bundle ]['password'];
            $system = $conn[ $bundle ]['system'];

            try{
                if($system == 'MySQL'){
                    $this->connexion = new \PDO('mysql:host='.$host.';dbname='.$dbname.';charset=UTF8;', $username, $password, [ \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC ]);
                }
                elseif($system == 'PGSQL'){
                    $this->connexion = new \PDO('pgsql:dbname='.$dbname.';host='.$host, $username, $password);
                    $this->connexion->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                }
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                return new ConnexionORMFail();
            }
        }

        /**
         * @return mixed
         */
        public function getConnexion(){
            return $this->connexion;
        }
    }