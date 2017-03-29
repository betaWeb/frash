<?php
namespace Frash\Framework\Browser;
use Frash\Framework\DIC\Dic;
use Frash\Framework\Request\Session;
use Frash\Framework\Request\Server\Server;

class Client{
	/**
	 * @var string
	 */
	private $content = '';

	/**
	 * @var Dic
	 */
	private $dic;

	/**
	 * @var string
	 */
	private $method = 'GET';

	/**
	 * @var string
	 */
	private $prefix;

	/**
	 * @var array
	 */
	private $response_header = [];

	/**
	 * @var string
	 */
	private $url = '';

	/**
     * Client constructor.
     * @param Dic $dic
     */
	public function __construct(Dic $dic){
		$this->dic = $dic;
		$this->prefix = (string) $this->dic->prefix_lang;
	}

	/**
	 * @return string
	 */
	public function getContent(){
		return $this->content;
	}

	/**
	 * @return array
	 */
	public function getResponseHeader(){
		return $this->response_header;
	}

	/**
	 * @return int
	 */
	public function getResponseCode(): int{
		if(preg_match('/(.*) (\d*) (.*)/', $this->getResponseHeader()[0], $response_code)){
			return $response_code[2];
		}
	}

	public function go(){
		$context = stream_context_create([
			'http' => [
				'method' => $this->method,
				'header' => 'Cookie: '.$_SERVER['HTTP_COOKIE']."\r\n"
			]
		]);

		session_write_close();
		$content = file_get_contents('http://'.Server::httpHost().$this->url, false, $context);
		session_start();

		$this->content = $content;
		$this->response_header = $http_response_header;
	}

	/**
	 * @param string $method
	 * @return Client
	 */
	public function method(string $method): Client{
		$this->method = $method;
		return $this;
	}

	/**
	 * @param string $route
	 * @return Client
	 */
	public function route(string $route): Client{
		$this->url = $this->prefix.'/'.$route;
		return $this;
	}

	/**
	 * @return Session
	 */
	public function session(): Session{
		return $this->dic->load('session');
	}
}