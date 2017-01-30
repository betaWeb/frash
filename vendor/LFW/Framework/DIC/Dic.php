<?php
namespace LFW\Framework\DIC;
use LFW\Framework\FileSystem\Json;

/**
 * Class Dic
 * @package LFW\Framework\DIC
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
     */
    public function __construct(){
        $this->dependencies = Json::importDependencies();
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key){
        if(empty($this->params[ $key ])){
            return [];
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
     * @param mixed $param
     * @return object
     */
    public function load($key, $param = ''){
        if(array_key_exists($key, $this->open)){
            return $this->open[ $key ];
        } elseif(array_key_exists($key, $this->dependencies)) {
            $path = str_replace('.', '\\', $this->dependencies[ $key ]);

            $class = new $path($this, $param);
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