<?php
namespace Frash\Framework\Request;
use Frash\Framework\DIC\Dic;

/**
 * Class Request
 * @package Frash\Framework\Request
 */
class Request
{
	/**
	 * @var array
	 */
	private $custom_get = [];

	/**
	 * @var Dic
	 */
	private $dic;

    /**
     * Request constructor.
     * @param Dic $dic
     */
	public function __construct(Dic $dic)
	{
		$this->dic = $dic;
	}

	/**
	 * @param array $getUrl
	 */
	public function setCustomGet(array $getUrl)
	{
		$this->custom_get = $getUrl;
	}

	/**
	 * @return object
	 */
	public function get()
	{
		$gets = array_merge($_GET, $this->custom_get);
		return (object) $gets;
	}

	/**
	 * @return object
	 */
	public function post()
	{
		return (object) $_POST;
	}

    /**
     * @param string $url
     * @return string
     */
    public function url(string $url, bool $type = true): string
    {
    	if($type){
    		return $this->dic->prefix_lang.'/'.$url;
    	} else {
    		return $this->dic->prefix.'/'.$url;
    	}
    }
}