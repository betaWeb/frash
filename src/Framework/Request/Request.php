<?php
namespace Frash\Framework\Request;

/**
 * Class Request
 * @package Frash\Framework\Request
 */
class Request
{
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
	 * @return object
	 */
	public function collectGet()
	{
		return (object) $_GET;
	}

	/**
	 * @return object
	 */
	public function collectPost()
	{
		return (object) $_POST;
	}
}