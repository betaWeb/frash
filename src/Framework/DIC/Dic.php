<?php
namespace Frash\Framework\DIC;
use Configuration\{ Config, Console, Database, Dependencies, Service };
use Frash\Framework\Request\Response;
use Frash\Framework\Request\Server\Server;

/**
 * Class Dic
 * @package Frash\Framework\DIC
 */
class Dic
{
    /**
     * @var array
     */
    private $config = [];

    /**
     * @var array
     */
    private $console = [];

    /**
     * @var array
     */
    private $database = [];

    /**
     * @var array
     */
    private $dependencies = [];

    /**
     * @var string
     */
    private $env = '';

    /**
     * @var array
     */
    private $open = [];

    /**
     * @var array
     */
    private $params = [];

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var array
     */
    private $service = [];

    /**
     * Dic constructor.
     * @param string $env
     */
    public function __construct(string $env = 'navigator')
    {
        $this->env = $env;
        $this->homepage = 'vendor/alixsperoza/frash/ressources/views/homepage.tpl';
    }

    public function preloading()
    {
        $this->loadDependencies()->loadConfiguration()->loadSession();
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function __get(string $key){
        if(!empty($this->$key)){
            return $this->$key;
        } elseif(!empty($this->params[ $key ])) {
            return $this->params[ $key ];
        } else {
            return '';
        }
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function __set(string $key, $value){
        $this->params[ $key ] = $value;
    }

    /**
     * @param string $key
     * @return object
     */
    public function load(string $key)
    {
        if(array_key_exists($key, $this->open)){
            return $this->open[ $key ];
        } elseif(array_key_exists($key, $this->dependencies)) {
            $class = new $this->dependencies[ $key ]($this);
            $this->open[ $key ] = $class;

            if($key == 'orm'){
                $this->pdo = $class->pdo;
            }

            return $class;
        }
    }

    /**
     * @param string $key
     * @param string $name
     * @return object
     */
    public function loadSpecial(string $key, string $name)
    {
        if(in_array($key, $this->dependencies)){
            $key = array_search($key, $this->dependencies);

            if(array_key_exists($key, $this->open)){
                return $this->open[ $key ];
            }

            $class = new $this->dependencies[ $key ]($this);
        } elseif(substr($key, -10) == 'Repository' || substr($key, -6) == 'Finder' || substr($key, -7) == 'Counter') {
            $this->pdo = $this->load('orm')->pdo;
            $class = new $key($this);
        } else {
            $class = new $key($this);
        }

        $this->open[ $name ] = $class;
        return $class;
    }

    /**
     * @return Dic
     */
    private function loadConfiguration(): Dic
    {
        if(!class_exists('Configuration\Config')){
            die('Configuration file could not be loaded.');
        }

        $this->config = Config::define();
        $this->checkLoad([ 'Database', 'Routing', 'Service' ]);

        $this->database = Database::define();
        $this->service = Service::define();

        if($this->env == 'console'){
            $this->checkLoad('Console');
            $this->console = Console::define();
        }

        return $this;
    }

    /**
     * @return Dic
     */
    private function loadDependencies(): Dic
    {
        if(!class_exists('Configuration\Dependencies')){
            die('Dependencies file could not be loaded.');
        }

        $this->dependencies = Dependencies::define();
        return $this;
    }

    /**
     * @return Dic
     */
    private function loadSession(): Dic
    {
        $session = $this->load('session');

        if(!empty($this->config['stock_route']) && $this->config['stock_route'] == 'yes' && $this->env != 'console' && !Response::xmlhttprequest()){
            if($session->has('frash_current_url') || !Server::httpReferer()){
                $session->set('frash_before_url', $session->get('frash_current_url'));
            } else {
                $session->set('frash_before_url', Server::httpReferer());
            }

            $session->set('frash_current_url', Server::uri());
        }

        return $this;
    }

    /**
     * @param string|array $class
     */
    private function checkLoad($class)
    {
        if(is_array($class)){
            foreach($class as $name_class){
                if(!class_exists('Configuration\\'.$name_class)){
                    $this->load('exception')->publish($name_class.' file could not be loaded');
                }
            }
        } else {
            if(!class_exists('Configuration\\'.$class)){
                $this->load('exception')->publish($class.' file could not be loaded');
            }
        }
    }
}