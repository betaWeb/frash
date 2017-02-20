<?php
namespace LFW\Framework\Cache;
use LFW\Framework\DIC\Dic;
use LFW\Framework\Log\CreateLog;

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
		$this->liste = $dic->get('conf')['config']['cache']['memcached'];
		$this->memcache = new \Memcached;
	}

	public function version(){
		return $this->memcache->getVersion();
	}

	public function server(){
		foreach($this->liste as $name => $port){
			try{
				$this->memcache->addServer($name, $port);
			}
			catch(\MemcachedException $e){
				CreateLog::error($e->getMessage(), $this->dic->get('conf')['config']['log']);
            	die('Il y a eu une erreur avec un serveur Memcached.');
			}
		}
	}

	/**
	 * @param string $key
	 * @return mixed
	 */
	public function get(string $key){
		return $this->memcache->get($key);
	}

	public function set(string $key, $value, $time = 3600){
		if(is_array($value)){
			$std = (object) $value;
			$this->memcache->add($key, $std, $time);
		} else {
			$this->memcache->add($key, $value, $time);
		}
	}
}