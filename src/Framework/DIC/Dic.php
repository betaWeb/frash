<?php
namespace Frash\Framework\DIC;
use Configuration\{ Config, Console, Database, Dependencies, Routing, Service };
use Frash\Framework\ExtensionLoaded;
use Frash\Framework\Request\Session;

/**
 * Class Dic
 * @package Frash\Framework\DIC
 */
class Dic{
    /**
     * @var array
     */
    private $dependencies = [];

    /**
     * @var array
     */
    private $open = [];

    /**
     * @var array
     */
    private $params = [];

    /**
     * Dic constructor.
     * @param string $env
     */
    public function __construct(string $env = 'navigator'){
        $this->params['conf'] = [ 'config' => Config::define(), 'console' => Console::define(), 'database' => Database::define(), 'routing' => new Routing(), 'service' => Service::define() ];
        $this->dependencies = Dependencies::define();
        $this->set('memcached', ExtensionLoaded::memcached());

        if($this->get('memcached') === true){
            $this->load('memcached')->server();
        }

        if($env == 'navigator'){
            $flashbags = Navigator::define($this, $env, $this->params['conf']['config']['stock_route']);

            foreach($flashbags as $flash => $value){
                $this->params[ $flash ] = $value;
            }
        }
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key){
        if(empty($this->params[ $key ])){
            return '';
        } else {
            return $this->params[ $key ];
        }
    }

    /**
     * @param array $keys
     * @return array
     */
    public function gets(array $keys){
        foreach($keys as $k){
            $array[ $k ] = $this->params[ $k ];
        }

        return $array;
    }

    /**
     * @param string $key
     * @return object
     */
    public function load(string $key){
        if(array_key_exists($key, $this->open)){
            return $this->open[ $key ];
        } elseif(array_key_exists($key, $this->dependencies)) {
            $path = str_replace('.', '\\', $this->dependencies[ $key ]);

            $class = new $path($this);
            $this->open[ $key ] = $class;

            return $class;
        }
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function set(string $key, $value){
        $this->params[ $key ] = $value;
    }

    /**
     * @param array $params
     */
    public function sets(array $params){
        foreach($params as $k => $v){
            $this->params[ $k ] = $v;
        }
    }
}