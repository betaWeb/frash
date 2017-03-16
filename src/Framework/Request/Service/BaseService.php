<?php
namespace Frash\Framework\Request\Service;
use Frash\Framework\DIC\Dic;

/**
 * Class BaseService
 * @package Frash\Framework\Request\Service
 */
class BaseService{
	/**
	 * @var Dic
	 */
	protected $dic;

	/**
	 * @var object
	 */
	protected $orm;

	/**
	 * @var object
	 */
	protected $redirect;

	/**
	 * @var object
	 */
	protected $session;

    /**
     * BaseService constructor.
     * @param Dic $dic
     */
	public function __construct(Dic $dic){
		$this->dic = $dic;
		$this->orm = $this->dic->load('orm');
		$this->redirect = $this->dic->load('redirect');
		$this->session = $this->dic->load('session');
	}
}