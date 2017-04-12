<?php
namespace Frash\Framework\Cache;
use Frash\Framework\DIC\Dic;
use Frash\Framework\Log\CreateLog;

/**
 * Class MemCache
 * @package Frash\Framework\MemCache
 */
class MemCache{
	/**
	 * @var Dic
	 */
	private $dic;

	/**
	 * @var array
	 */
	private $liste = [];

	/**
	 * @var \Memcached
	 */
	private $memcache;

	/**
	 * @param Dic $dic
	 */
	public function __construct(Dic $dic){
		$this->dic = $dic;
		$this->liste = $dic->conf['config']['cache']['memcached'];
		$this->memcache = new \Memcached;
	}

	public function version(){
		return $this->memcache->getVersion();
	}

	public function server(){
		foreach($this->liste as $name => $port){
			try{
				$this->memcache->addServer($name, $port);
			} catch(\MemcachedException $e) {
				CreateLog::error($e->getMessage(), $this->dic->conf['config']['log']);
            	die('Il y a eu une erreur avec un serveur Memcached.');
			}
		}
	}

	/**
	 * @param string $key
	 * @return mixed|bool
	 */
	public function get(string $key){
		if(!empty($this->memcache->get($key))){
			return $this->memcache->get($key);
		} else {
			return false;
		}
	}

	/**
	 * @param string $key
	 * @param mixed $value
	 * @param integer $time
	 */
	public function set(string $key, $value, $time = 3600){
		if(is_array($value)){
			$std = (object) $value;
			$this->memcache->add($key, $std, $time);
		} else {
			$this->memcache->add($key, $value, $time);
		}
	}
}