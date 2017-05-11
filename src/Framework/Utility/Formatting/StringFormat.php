<?php
namespace Frash\Framework\Utility\Formatting;

/**
 * Class StringFormat
 * @package Frash\Framework\Utility\Formatting
 */
class StringFormat
{
	/**
	 * @var string
	 */
	private $chaine;

    /**
     * StringFormat constructor.
     * @param string $chaine
     */
	public function __construct(string $chaine)
	{
		$this->chaine = $chaine;
	}

	/**
	 * @return string
	 */
	public function get(): string
	{
		return $this->chaine;
	}

	/**
	 * @param mixed $search
	 * @param mixed $replace
	 * @return StringFormat
	 */
	public function replace($search, $replace): StringFormat
	{
		$this->chaine = str_replace($search, $replace, $this->chaine);
		return $this;
	}
}